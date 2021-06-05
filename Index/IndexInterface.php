<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ElasticsearchBundle\Index;

use Phoenix\ElasticsearchBundle\Document\AbstractDocument;

/**
 * Class IndexInterface
 * @package Phoenix\ElasticsearchBundle\Index
 * @author Hiren Chhatbar
 */
interface IndexInterface
{
    /**
     * Returns mappings.
     *
     * @return array
     */
    public function mappings(): array;

    /**
     * Returns mappings to be updated.
     *
     * @return array
     */
    public function mappingsToUpdate(): array;

    /**
     * Returns settings.
     *
     * @return array
     */
    public function settings(): array;

    /**
     * Returns settings to be updated.
     *
     * @return array
     */
    public function settingsToUpdate(): array;

    /**
     * Returns object of AbstractDocument.
     *
     * @return AbstractDocument
     */
    public function document(): AbstractDocument;
}