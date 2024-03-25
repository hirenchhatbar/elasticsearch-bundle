<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ElasticsearchBundle\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

/**
 * Class ClientService
 * @package Phoenix\ElasticsearchBundle\Service
 * @author Hiren Chhatbar
 * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/connceting.html
 * @link https://symfony.com/doc/current/service_container/shared.html
 */
class ClientService
{
    /**
     * Holds hosts.
     *
     * @var array
     */
    protected array $hosts;

    /**
     * SSL certificate
     *
     * @var string|null
     */
    protected ?string $sslCert = null;

    /**
     * Username
     *
     * @var string|null
     */
    protected ?string $username = null;

    /**
     * Password
     *
     * @var string|null
     */
    protected ?string $password = null;

    /**
     * Holds object of Client.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * Constructor.
     *
     * @param array $hosts
     * @param string|null $sslCert
     * @param string|null $username
     * @param string|null $password
     */
    public function __construct(array $hosts, ?string $sslCert = null, ?string $username = null, ?string $password = null)
    {
        $this->hosts = $hosts;
        $this->sslCert = $sslCert;
        $this->username = $username;
        $this->password = $password;

        if (!isset($this->client)) {
            $this->set();
        }
    }

    /**
     * Returns ES client.
     *
     * @return Client
     */
    public function get(): Client
    {
        return $this->client;
    }

    /**
     * Sets client.
     *
     * @return void
     */
    public function set(): void
    {
        $clientBuilder = ClientBuilder::create()->setHosts($this->hosts);

        if ($this->username && $this->password) {
            $clientBuilder->setBasicAuthentication($this->username, $this->password);
        }

        if ($this->sslCert) {
            $clientBuilder->setCABundle($this->sslCert);
        }

        $this->client = $clientBuilder->build();
    }
}
