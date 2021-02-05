<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\Command;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Phoenix\EasyElasticsearchBundle\Finder\IndexFinder;
use Phoenix\EasyElasticsearchBundle\Manager\DocumentManager;
use Phoenix\EasyElasticsearchBundle\Utils\Util;

/**
 * Class DocumentCommand
 * @package Phoenix\EasyElasticsearchBundle\Command
 * @author Hiren Chhatbar
 */
class DocumentCommand extends AbstractPageCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'phoenix:elasticsearch:document';

    /**
     * Holds object of DocumentManager.
     *
     * @var DocumentManager
     */
    protected DocumentManager $documentManager;

    /**
     * Holds object of IndexFinder.
     *
     * @var IndexFinder
     */
    protected IndexFinder $indexFinder;

    /**
     * Constructor.
     *
     * @param DocumentManager $documentManager
     * @param IndexFinder $indexFinder
     */
    public function __construct(Util $util, DocumentManager $documentManager, IndexFinder $indexFinder)
    {
        $this->documentManager = $documentManager;

        $this->indexFinder = $indexFinder;

        parent::__construct($util);
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Command\AbstractPageCommand::configure()
     */
    protected function configure()
    {
        parent::configure();

        $this->addOption(
            'name',
            'na',
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
     * @see \Phoenix\EasyElasticsearchBundle\Command\AbstractPageCommand::execute()
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
     * @see \Phoenix\EasyElasticsearchBundle\Command\AbstractPageCommand::queryBuilder()
     */
    protected function queryBuilder(int $page = 1): QueryBuilder
    {

    }

    /**
     * Sync document with ES.
     *
     * @desc Operation will be performed in batch and query for bulk will be called.
     */
    public function sync(array $data): void
    {

    }

    /**
     * Sync document by ID
     */
    public function syncById(): void
    {

    }

    /**
     * Deletes all documents.
     */
    public function deleteAll(): void
    {

    }

    /**
     * Deletes documents by query
     */
    public function deleteByQuery(): void
    {

    }

    /**
     * Deletes document by ID
     */
    public function deleteById(): void
    {

    }
}