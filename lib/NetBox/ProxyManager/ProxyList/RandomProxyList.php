<?php
/**
 * This file is part of the %PRODUCT_NAME% package.
 * Date: 18.09.12
 * Time: 13:34
 *
 * (c) Dmitriy Protasov <dmitriy.protasov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NetBox\ProxyManager\ProxyList;

use NetBox\ProxyManager\Proxy\Proxy;

class RandomProxyList extends ProxyList
{
    /**
     * @throws \UnderflowException
     */
    public function select()
    {
        if (count($this->proxies) == 0) {
            throw new \UnderflowException('No proxies in list');
        }

        /* @var Proxy $proxy */
        $key = array_rand($this->proxies);
        $proxy = $this->proxies[$key];
        unset($this->proxies[$key]);

        $this->selected[$proxy->getHash()] = $proxy;
    }
}
