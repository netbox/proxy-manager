<?php
/**
 * This file is part of the %PRODUCT_NAME% package.
 * Date: 18.09.12
 * Time: 12:29
 *
 * (c) Dmitriy Protasov <dmitriy.protasov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NetBox\ProxyManager\Proxy;

class CookieProxy extends Proxy
{
    private $cookiePath;

    public function __construct($proxy, $type = self::HTTP)
    {
        parent::__construct($proxy, $type);
        $this->initCookiePath();
    }

    public function getCookiePath()
    {
        return $this->cookiePath;
    }

    private function initCookiePath()
    {
        $dir = '/tmp/proxy-manager/cookie/' . implode('/', explode('.', $this->getIp()));

        $this->cookiePath = $dir . '/' . $this->getPort() . '.txt';

        if (!is_dir($dir)) {
            @mkdir($dir, 0750, true);
        }
    }
}
