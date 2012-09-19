<?php
/**
 * This file is part of the %PRODUCT_NAME% package.
 * Date: 17.09.12
 * Time: 18:46
 *
 * (c) Dmitriy Protasov <dmitriy.protasov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NetBox\ProxyManager\Storage;

use NetBox\ProxyManager\Proxy\Proxy;

abstract class AbstractStorageAdapter
{
    private $proxyClassName = '\\NetBox\\ProxyManager\\Proxy';

    /**
     * @return array|\NetBox\ProxyManager\Proxy\Proxy[]
     */
    abstract public function getAll();

    /**
     * @param \NetBox\ProxyManager\Proxy\Proxy $proxy
     * @return mixed
     */
    abstract public function update(\NetBox\ProxyManager\Proxy\Proxy $proxy);

    /**
     * Flush all changes
     * @return void
     */
    abstract public function flush();

    /**
     * @param string $proxyClassName
     */
    public function setProxyClassName($proxyClassName)
    {
        $this->proxyClassName = $proxyClassName;
    }

    public function getProxyClassName()
    {
        return $this->proxyClassName;
    }
}
