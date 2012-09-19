<?php
/**
 * This file is part of the %PRODUCT_NAME% package.
 * Date: 17.09.12
 * Time: 18:08
 *
 * (c) Dmitriy Protasov <dmitriy.protasov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NetBox\ProxyManager\ProxyList;

use NetBox\ProxyManager\Proxy\Proxy;

class ProxyList
{
    protected $proxies = array();
    protected $selected = array();

    protected $proxyHashes = array();

    /**
     * Add proxy in list
     *
     * @param \NetBox\ProxyManager\Proxy\Proxy $proxy
     *
     * @throws \InvalidArgumentException
     */
    public function add(Proxy $proxy)
    {
        if (in_array($proxy->getHash(), $this->proxyHashes) !== false) {
            throw new \InvalidArgumentException('This proxy already in list: "' . $proxy . '"');
        }

        $this->proxyHashes[] = $proxy->getHash();
        $this->proxies[] = $proxy;
    }

    /**
     * @param \NetBox\ProxyManager\Proxy\Proxy $proxy
     *
     * @return bool
     */
    public function has(Proxy $proxy)
    {
        return in_array($proxy->getHash(), $this->proxyHashes);
    }

    /**
     * @param \NetBox\ProxyManager\Proxy\Proxy $proxy
     */
    public function remove(Proxy $proxy)
    {
        if (($key = array_search($proxy, $this->proxies)) !== false) {
            unset($this->proxies[$key]);
        }
        if (isset($this->selected[$proxy->getHash()])) {
            unset($this->selected[$proxy->getHash()]);
        }
    }

    /**
     * @throws \UnderflowException
     * @return \NetBox\ProxyManager\Proxy\Proxy
     */
    public function select()
    {
        if (count($this->proxies) == 0) {
            throw new \UnderflowException('No proxies in list');
        }

        /* @var Proxy $proxy */
        $proxy = array_shift($this->proxies);
        $this->selected[$proxy->getHash()] = $proxy;

        return $proxy;
    }

    /**
     * @param \NetBox\ProxyManager\Proxy\Proxy $proxy
     * @throws \OutOfBoundsException
     */
    public function unSelect(Proxy $proxy)
    {
        if (!isset($this->selected[$proxy->getHash()])) {
            throw new \OutOfBoundsException('This proxy not in list: "' . $proxy . '"');
        }

        $this->proxies[] = $proxy;
        unset($this->selected[$proxy->getHash()]);
    }

    public function unSelectAll()
    {
        while ($proxy = array_pop($this->selected)) {
            $this->proxies[] = $proxy;
        }
    }

    /**
     * Return count proxy in stack
     *
     * @return int
     */
    public function getSize()
    {
        return count($this->proxies);
    }

    /**
     * @return \ArrayObject $iterator
     */
    public function getIterator()
    {
        return new \ArrayObject($this->proxies);
    }
}
