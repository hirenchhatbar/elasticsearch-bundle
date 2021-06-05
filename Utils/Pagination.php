<?php
/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ElasticsearchBundle\Utils;

/**
 * Class Pagination
 * @package Phoenix\ElasticsearchBundle\Utils
 * @author Hiren Chhatbar
 */
class Pagination
{
    /**
     * Returns info to render pagination.
     *
     * @param int $totalCount
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function info(int $totalCount, int $limit, int $offset = 0): array
    {
        return [
            'total_count' => $totalCount,
            'offset_start' => $offset,
            'offset_end' => ($offset + $limit) - 1,
            'offset_start_display' => ($offset + 1),
            'offset_end_display' => ($offset + $limit),
            'limit' => $limit,
            'total_page' => $totalCount > 0 ? ceil($totalCount / $limit) : 0,
            'page' => $offset > 0 ? (ceil(($offset + 1) / $limit)) : 1,
            'rows' => [],
        ];
    }
}