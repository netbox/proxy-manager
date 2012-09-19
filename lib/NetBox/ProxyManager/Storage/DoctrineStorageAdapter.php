<?php
/**
 * This file is part of the %PRODUCT_NAME% package.
 * Date: 19.09.12
 * Time: 10:49
 *
 * (c) Dmitriy Protasov <dmitriy.protasov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NetBox\ProxyManager\Storage;

use NetBox\ProxyManager\Proxy\Proxy;

/**
 * Database schema see @todo documentation
 */
class DoctrineStorageAdapter extends AbstractStorageAdapter
{
    /**
     * @var \Doctrine\DBAL\Connection $connection
     */
    private $connection;

    public function __construct(array $params)
    {
        $this->connection = \Doctrine\DBAL\DriverManager::getConnection($params, new \Doctrine\DBAL\Configuration());
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    protected function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return array|\NetBox\ProxyManager\Proxy\Proxy[]
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param \NetBox\ProxyManager\Proxy\Proxy $proxy
     * @return mixed
     */
    public function update(Proxy $proxy)
    {
        // TODO: Implement update() method.
    }

    /**
     * Flush all changes
     * @return void
     */
    public function flush()
    {
        // TODO: Implement flush() method.
    }
}
