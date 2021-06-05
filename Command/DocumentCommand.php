<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ElasticsearchBundle\Command;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Phoenix\ElasticsearchBundle\Utils\Util;
use Phoenix\ElasticsearchBundle\Service\DocumentService;
use Phoenix\ElasticsearchBundle\Finder\IndexFinder;

/**
 * Class DocumentCommand
 * @package Phoenix\ElasticsearchBundle\Command
 * @author Hiren Chhatbar
 */
class DocumentCommand extends AbstractPageCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'phoenix:elasticsearch:document';

    /**
     * Holds object of DocumentService.
     *
     * @var DocumentService
     */
    protected DocumentService $documentService;

    /**
     * Holds object of IndexFinder.
     *
     * @var IndexFinder
     */
    protected IndexFinder $indexFinder;

    /**
     * Constructor.
     *
     * @param Util $util
     * @param DocumentService $documentService
     * @param IndexFinder $indexFinder
     */
    public function __construct(Util $util, DocumentService $documentService, IndexFinder $indexFinder)
    {
        $this->documentService = $documentService;

        $this->indexFinder = $indexFinder;

        parent::__construct($util);
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Command\AbstractPageCommand::configure()
     */
    protected function configure()
    {
        parent::configure();

        $this->addOption(
            'index',
            'idx',
            InputOption::VALUE_REQUIRED,
            'Name of index'
        );

        $this->addOption(
            'id',
            'i',
            InputOption::VALUE_OPTIONAL,
            'Document ID which can be single or multiple comma separated'
        );
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Command\AbstractPageCommand::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ('sync' == $input->getArgument('action')) {
            return parent::execute($input, $output);
        } else {
            return AbstractCommand::execute($input, $output);
        }
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Command\AbstractPageCommand::queryBuilder()
     */
    protected function queryBuilder(int $page = 1): QueryBuilder
    {
        $indexName = $this->input->getOption('index');

        $index = $this->indexFinder->find($indexName);

        return $index->document()->queryBuilder();
    }

    /**
     * Sync document with ES.
     *
     * @desc Operation will be performed in batch and query for bulk will be called.
     */
    public function sync(array $data): void
    {
        $indexName = $this->input->getOption('index');

        $index = $this->indexFinder->find($indexName);

        $rows = [];

        foreach ($data as $row) {
            $rows[] = $index->document()->get($row['id']);
        }

        $this->documentService->indexBulk($index->name(), $rows);
    }

    /**
     * Sync document by ID
     */
    public function syncById(): void
    {
        $indexName = $this->input->getOption('index');

        $id = $this->input->getOption('id');

        $index = $this->indexFinder->find($indexName);

        $this->documentService->index($index->name(), $id, $index->document()->get($id));
    }

    /**
     * Deletes all documents.
     */
    public function deleteAll(): void
    {
        $indexName = $this->input->getOption('index');

        $index = $this->indexFinder->find($indexName);

        $this->documentService->deleteAll($index->name());
    }

    /**
     * Deletes document by ID
     */
    public function deleteById(): void
    {
        $indexName = $this->input->getOption('index');

        $id = $this->input->getOption('id');

        $index = $this->indexFinder->find($indexName);

        $this->documentService->delete($index->name(), $id);
    }

    /**
     * Sync document by ID
     */
    public function get(): void
    {
        $indexName = $this->input->getOption('index');

        $id = $this->input->getOption('id');

        $index = $this->indexFinder->find($indexName);

        print_r($this->documentService->get($index->name(), $id));
    }
}