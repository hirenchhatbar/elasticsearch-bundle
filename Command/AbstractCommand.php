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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 * @package Phoenix\ElasticsearchBundle\Command
 * @author Hiren Chhatbar
 */
abstract class AbstractCommand extends Command
{
    /**
     * Holds object of InputInterface.
     *
     * @var InputInterface
     */
    protected InputInterface $input;

    /**
     * Holds object of OutputInterface.
     *
     * @var OutputInterface
     */
    protected OutputInterface $output;

    /**
     * {@inheritDoc}
     *
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this->addArgument(
            'action',
            InputArgument::REQUIRED,
            'Action',
        );
    }

    /**
     * {@inheritDoc}
     *
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input  = $input;
        $this->output = $output;

        $action = \str_replace('-', '', \lcfirst(\ucwords(\strtolower($input->getArgument('action')), '-')));

        if (method_exists($this, $action)) {
            $this->$action();

            return Command::SUCCESS;
        }

        $output->writeln('<bg=red;fg=white;options=blink>Oops! action seems undefined, please check</>');

        return Command::FAILURE;
    }
}

