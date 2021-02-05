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

use Phoenix\EasyElasticsearchBundle\Manager\IndexManager;
use Phoenix\EasyElasticsearchBundle\Finder\IndexFinder;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class IndexCommand
 * @package Phoenix\EasyElasticsearchBundle\Command
 * @author Hiren Chhatbar
 */
class IndexCommand extends AbstractCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'phoenix:elasticsearch:index';

    /**
     * Holds object of IndexManager.
     *
     * @var IndexManager
     */
    protected IndexManager $indexManager;

    /**
     * Holds object of IndexFinder.
     *
     * @var IndexFinder
     */
    protected IndexFinder $indexFinder;

    /**
     * Constructor.
     *
     * @param IndexManager $indexManager
     */
    public function __construct(IndexManager $indexManager, IndexFinder $indexFinder)
    {
        $this->indexManager = $indexManager;

        $this->indexFinder = $indexFinder;

        parent::__construct();
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Command\AbstractCommand::configure()
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
    }

    /**
     * Creates index given.
     */
    public function create(): void
    {
        $name = $this->input->getOption('name');

        if ($this->indexManager->init($this->indexFinder->find($name))->create()) {
            $this->output->writeln('<fg=green;options=bold>Index successfully created.</>');
        } else {
            $this->output->writeln('<bg=red;fg=white;options=blink>Unable to create index, please try again.</>');
        }
    }

    /**
     * Deletes index given.
     */
    public function delete(): void
    {
        $name = $this->input->getOption('name');

        if ($this->indexManager->init($this->indexFinder->find($name))->delete()) {
            $this->output->writeln('<fg=green;options=bold>Index permanently deleted.</>');
        } else {
            $this->output->writeln('<bg=red;fg=white;options=blink>Unable to delete index, please try again.</>');
        }
    }

    /**
     * Checks whether index exists or not.
     */
    public function exists(): void
    {
        $name = $this->input->getOption('name');

        if ($this->indexManager->init($this->indexFinder->find($name))->exists()) {
            $this->output->writeln('<fg=green;options=bold>Index exists.</>');
        } else {
            $this->output->writeln('<bg=red;fg=white;options=blink>Index not present.</>');
        }
    }

    /**
     * Dumps mappings of index given.
     */
    public function mappings(): void
    {
        $name = $this->input->getOption('name');

        print_r($this->indexManager->init($this->indexFinder->find($name))->mappings());
    }

    /**
     * Dumps settings of index given.
     */
    public function settings(): void
    {
        $name = $this->input->getOption('name');

        print_r($this->indexManager->init($this->indexFinder->find($name))->settings());
    }

    /**
     * Updates existing settings of index given.
     */
    public function updateSettings(): void
    {
        $name = $this->input->getOption('name');

        if ($this->indexManager->init($this->indexFinder->find($name))->updateSettings()) {
            $this->output->writeln('<fg=green;options=bold>Settings successfully updated.</>');
        } else {
            $this->output->writeln('<bg=red;fg=white;options=blink>Unable to update settings, please try again.</>');
        }
    }

    /**
     * Updates existing mappings of given index.
     */
    public function updateMappings(): void
    {
        $name = $this->input->getOption('name');

        if ($this->indexManager->init($this->indexFinder->find($name))->updateMappings()) {
            $this->output->writeln('<fg=green;options=bold>Mappings successfully updated.</>');
        } else {
            $this->output->writeln('<bg=red;fg=white;options=blink>Unable to update mappings, please try again.</>');
        }
    }
}