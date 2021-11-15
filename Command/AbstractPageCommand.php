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

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Phoenix\ElasticsearchBundle\Utils\Util;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AbstractPageCommand
 * @package Phoenix\ElasticsearchBundle\Command
 * @author Hiren Chhatbar
 */
abstract class AbstractPageCommand extends AbstractCommand
{
    /**
     * Per page limit.
     *
     * @var string
     */
    protected int $perPage = 500;

    /**
     * Whether to perform process in bulk or not.
     *
     * @var boolean
     */
    protected bool $bulk = true;

    /**
     * Constructor.
     *
     * @param Util $util
     */
    public function __construct(Util $util)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->util = $util;

        parent::__construct();
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Command\AbstractCommand::configure()
     */
    protected function configure()
    {
        parent::configure();

        $this->addOption(
            'page',
            'p',
            InputOption::VALUE_OPTIONAL,
            'Page',
            null
        );
    }

    /**
     * {@inheritDoc}
     *
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        if (null === ($page = $this->input->getOption('page'))) {
            $this->output->writeln('Command started... ');

            $this->pages();

            $this->output->writeln('done. ');
        } else {
            $this->page($page);
        }

        return Command::SUCCESS;
    }

    /**
     * Returns count.
     *
     * @return int
     */
    protected function count(): int
    {
        $qb = $this->queryBuilder();

        $aliases = $qb->getRootAliases();

        $alias = \reset($aliases);

        $cntQb = clone $qb;

        $cntQb->select(sprintf('COUNT(%s.id)', $alias));

        $cntQb->resetDQLPart('orderBy');
        $cntQb->resetDQLPart('distinct');

        $totalCount = $cntQb->getQuery()->getSingleScalarResult();

        return ($totalCount > 0 ? ceil($totalCount / $this->perPage) : 0);
    }

    /**
     * Returns log to be written on console basically.
     *
     * @param array $row
     *
     * @return string
     */
    protected function log(array $row): string
    {
        return sprintf('ID #%s', $row['id']);
    }

    /**
     * Returns result.
     *
     * @param int $page
     *
     * @return array
     */
    abstract protected function queryBuilder(int $page = 1): QueryBuilder;

    /**
     * Processes single page.
     *
     * @param int $number
     */
    final protected function page(int $number): void
    {
        $qb = $this->queryBuilder($number);

        $result = $qb->getQuery()
            ->setMaxResults($this->perPage)
            ->setFirstResult($this->offsetByPage($number))
            ->getArrayResult()
        ;

        if ($this->bulk) {
            $this->process($result);
        } else {
            $this->iterate($result);
        }
    }

    /**
     * Processes individual row.
     *
     * @param array $row
     */
    final protected function process(array $data): void
    {
        $action = \str_replace('-', '', \lcfirst(\ucwords(\strtolower($this->input->getArgument('action')), '-')));

        if (method_exists($this, $action)) {
            $this->$action($data);
        } else {
            $this->output->writeln('<bg=red;fg=white;options=blink>Oops! action seems undefined, please check</>');
        }
    }

    /**
     * Processes all pages.
     */
    final protected function pages(): void
    {
        $count = $this->count();

        for ($page = 1; $page <= $count; $page++) {
            $this->output->writeln(sprintf('Page #%s', $page));

            $options = \array_merge($this->input->getOptions(), ['page' => $page]);

            $arguments = $this->input->getArguments();

            unset($arguments['command']);

            $this->util->cliCommand($this->getDefaultName(), array_filter($options), $arguments);
        }
    }

    /**
     * Iterates through all rows of single page and process each of them.
     *
     * @param array $rows
     */
    final protected function iterate(array $rows): void
    {
        foreach ($rows as $row) {
            try {
                $this->output->write(sprintf('Processing: %s...', $this->log($row)));

                $this->process($row);

                $this->output->writeln('done');
            } catch (\Exception $e) {
                $this->output->writeln(sprintf('error: %s at line %s in %s', $e->getMessage(), $e->getLine(), $e->getFile()));
            }
        }
    }

    /**
     * Returns offset by page.
     *
     * @param int $page
     *
     * @return int
     */
    final protected function offsetByPage(int $page): int
    {
        return (($page - 1) * $this->perPage);
    }
}