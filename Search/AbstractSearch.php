<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ElasticsearchBundle\Search;

use Phoenix\ElasticsearchBundle\Service\DocumentService;
use Phoenix\ElasticsearchBundle\Utils\Pagination;
use Phoenix\ElasticsearchBundle\Utils\Util;
use Phoenix\ElasticsearchBundle\Index\AbstractIndex;

/**
 * Class AbstractSearch
 * @package Phoenix\ElasticsearchBundle\Search
 * @author Hiren Chhatbar
 */
abstract class AbstractSearch implements SearchInterface
{
    /**
     * Holds object of AbstractIndex.
     *
     * @var AbstractIndex
     */
    public AbstractIndex $index;

    /**
     * Holds object of DocumentService.
     *
     * @var DocumentService
     */
    protected DocumentService $documentService;

    /**
     * Holds object of Pagination.
     *
     * @var Pagination
     */
    protected Pagination $pagination;

    /**
     * Holds object of Util.
     *
     * @var Util
     */
    protected Util $util;

    /**
     * Constructor.
     *
     * @param DocumentService $documentService
     * @param Pagination $pagination
     * @param Util $util
     */
    public function __construct(DocumentService $documentService, Pagination $pagination, Util $util)
    {
        $this->documentService = $documentService;

        $this->pagination = $pagination;

        $this->util = $util;
    }
}