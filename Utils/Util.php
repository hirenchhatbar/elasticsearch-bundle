<?php
/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\Utils;

/**
 * Class Util
 * @package Phoenix\EasyElasticsearchBundle\Utils
 * @author Hiren Chhatbar
 */
class Util
{
    /**
     * Returns PHP path.
     *
     * @return string
     */
    public function phpPath(): string
    {
        return sprintf('%s/php', PHP_BINDIR);
    }

    /**
     * Returns path of symfony console.
     *
     * @return string
     */
    public function consolePath(): string
    {
        return sprintf('%s/bin/console', $this->projectDir);
    }

    /**
     * Runs CLI command.
     *
     * @param string $command
     * @param array $options
     * @param bool $background
     *
     * @return int|NULL
     */
    public function cliCommand(string $command, array $options, bool $background = false)
    {
        $cmdStr = $this->cliCommandString($command, $options);

        if ($background) {
            exec(sprintf('nohup %s > /dev/null 2>/dev/null &', $cmdStr));
        } else {
            passthru($cmdStr, $ret);

            return $ret;
        }
    }

    /**
     * Returns CLI command string.
     *
     * @param string $command
     * @param array $options
     *
     * @return string
     */
    public function cliCommandString(string $command, array $options): string
    {
        $optStr = [];

        foreach ($options as $opt => $optVal) {
            $optStr[] = sprintf('--%s=%s', $opt, $optVal);
        }

        $cmdStr = trim(sprintf(
            '%s %s %s %s',
            $this->phpPath(),
            $this->consolePath(),
            $command,
            implode(' ', $optStr)
        ));

        return $cmdStr;
    }
}