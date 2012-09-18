<?php
/**
 * This file is part of the %PRODUCT_NAME% package.
 * Date: 18.09.12
 * Time: 14:22
 *
 * (c) Dmitriy Protasov <dmitriy.protasov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NetBox\ProxyManager\ProxyList;

use NetBox\ProxyManager\Proxy\Proxy;

class SortProxyList extends ProxyList
{
    private $sorter;

    public function __construct($sorter)
    {
        if (!is_callable($sorter))
            throw new \InvalidArgumentException('Sorter is not callable');

        $this->sorter = $sorter;
    }

    /**
     * @param \NetBox\ProxyManager\Proxy\Proxy $proxy
     * @return \OutOfBoundsException|void
     * @throws \OutOfBoundsException
     */
    public function unSelect(Proxy $proxy)
    {
        parent::unSelect($proxy);

        $this->sortList();
    }

    public function unSelectAll()
    {
        parent::unSelectAll();

        $this->sortList();
    }

    public function sortList()
    {
        usort($this->proxies, $this->sorter);
    }
}
