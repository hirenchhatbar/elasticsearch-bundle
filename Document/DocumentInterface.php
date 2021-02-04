<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\Document;

use Doctrine\ORM\QueryBuilder;

/**
 * Class DocumentInterface
 * @package Phoenix\EasyElasticsearchBundle\Document
 * @author Hiren Chhatbar
 */
interface DocumentInterface
{
    /**
     * Returns document.
     *
     * @return array
     */
    public function get(): array;

    /**
     * Returns QueryBuilder to be used while sync documents.
     *
     * @return QueryBuilder
     */
    public function queryBuilder(): QueryBuilder;
}