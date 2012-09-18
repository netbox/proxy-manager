<?php
/**
 * This file is part of the %PRODUCT_NAME% package.
 * Date: 18.09.12
 * Time: 13:04
 *
 * (c) Dmitriy Protasov <dmitriy.protasov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NetBox\ProxyManager\ProxyList;

use NetBox\ProxyManager\Proxy\Proxy;

class TimeoutProxyList extends ProxyList
{
    private $timeout;

    /**
     * @param int $timeout Timeout between usage
     */
    public function __construct($timeout = 10)
    {
        $this->timeout = $timeout;
    }

    /**
     * @throws \UnderflowException
     * @return \NetBox\ProxyManager\Proxy\Proxy
     */
    public function select()
    {
        $proxy = parent::select();

        if (!is_null($proxy->getUsedAt())) {
            $delta = time() - $proxy->getUsedAt();
            if ($delta < $this->timeout) {
                $sleepSeconds = (int)($this->timeout - $delta);
                sleep($sleepSeconds);
            }
        }

        return $proxy;
    }

    /**
     * @param \NetBox\ProxyManager\Proxy\Proxy $proxy
     *
     * @throws \OutOfBoundsException
     */
    public function unSelect(Proxy $proxy)
    {
        if (!isset($this->selected[$proxy->getHash()])) {
            throw new \OutOfBoundsException('This proxy not in list: "' . $proxy . '"');
        }

        $proxy->setUsedAt(time());
        $this->proxies[] = $proxy;
        unset($this->selected[$proxy->getHash()]);
    }
}
