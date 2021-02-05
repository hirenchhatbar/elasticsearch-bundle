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

use Phoenix\EasyElasticsearchBundle\Service\ClientService;

/**
 * Class ClientCommand
 * @package Phoenix\EasyElasticsearchBundle\Command
 * @author Hiren Chhatbar
 */
class ClientCommand extends AbstractCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'phoenix:elasticsearch:client';

    /**
     * Holds object of ClientService.
     *
     * @var ClientService
     */
    protected ClientService $clientService;

    /**
     * Constructor.
     *
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;

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

        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Performs all operation related to elasticsearch server')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command performs all operation related to elasticsearch server...')
        ;
    }

    /**
     * Pings server.
     */
    public function ping(): void
    {
        if (true === $this->clientService->get()->ping()) {
            $this->output->writeln('<fg=green;options=bold>Successful, ping works.</>');
        } else {
            $this->output->writeln('<bg=red;fg=white;options=blink>Sorry, ping failed.</>');
        }
    }

    /**
     * Display server related info.
     */
    public function info(): void
    {
        print_r($this->clientService->get()->info());
    }
}