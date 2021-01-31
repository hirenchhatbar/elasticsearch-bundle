<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\Index;

/**
 * Class IndexInterface
 * @package Phoenix\EasyElasticsearchBundle\Index
 * @author Hiren Chhatbar
 */
interface IndexInterface
{
    /**
     * Returns mapping.
     *
     * @return array
     */
    public function mapping(): array;

    /**
     * Returns mapping to be updated.
     *
     * @return array
     */
    public function mappingToUpdate(): array;

    /**
     * Returns setting.
     *
     * @return array
     */
    public function setting(): array;

    /**
     * Returns setting to be updated.
     *
     * @return array
     */
    public function settingToUpdate(): array;
}