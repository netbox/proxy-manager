<?php
/**
 * This file is part of the %PRODUCT_NAME% package.
 * Date: 17.09.12
 * Time: 18:31
 *
 * (c) Dmitriy Protasov <dmitriy.protasov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NetBox\ProxyManager\Proxy;

class Proxy
{
    private $hash;
    private $ip;
    private $port;
    private $type;

    private $connectTime = null;
    private $totalTime = null;

    private $usedAt = null;

    private $attributes = array();

    private static $typeToCurlType = array(
        self::HTTP => CURLPROXY_HTTP,
        self::SOCKS4 => CURLPROXY_SOCKS4,
        self::SOCKS5 => CURLPROXY_SOCKS5
    );

    const HTTP = 'http';
    const SOCKS4 = 'socks4';
    const SOCKS5 = 'socks5';

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCurlType()
    {
        return self::$typeToCurlType[$this->type];
    }

    public function setConnectTime($connectTime)
    {
        $this->connectTime = $connectTime;
    }

    public function getConnectTime()
    {
        return $this->connectTime;
    }

    public function setUsedAt($usedAt)
    {
        $this->usedAt = $usedAt;
    }

    public function getUsedAt()
    {
        return $this->usedAt;
    }

    public function setTotalTime($totalTime)
    {
        $this->totalTime = $totalTime;
    }

    public function getTotalTime()
    {
        return $this->totalTime;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function __construct($address, $type = self::HTTP)
    {
        self::validateType($type);
        $proxyHostPort = self::getIpAndPort($address);

        $this->ip = $proxyHostPort['ip'];
        $this->port = $proxyHostPort['port'];
        $this->type = $type;

        $this->hash = md5($this->getIp() . '-' . $this->getPort() . '-' . $this->getType());
    }

    public function __toString()
    {
        return $this->getIp() . ':' . $this->getPort() . '@' . $this->getType();
    }

    public static function validateType($type)
    {
        if (!array_key_exists($type, self::$typeToCurlType)) {
            throw new \InvalidArgumentException('Invalid proxy type: "' . $type . '"');
        }
    }

    public static function getIpAndPort($proxy)
    {
        if (!preg_match('/^((\d+\.){3}\d+):(\d+)$/', $proxy, $matches) || $matches[3] < 1 || $matches[3] > 65535) {
            throw new \InvalidArgumentException('Invalid proxy format: "' . $proxy . '"');
        }

        $ip = $matches[1];
        $port = (integer)$matches[3];

        return array(
            'ip' => $ip,
            'port' => $port
        );
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function getAttribute($key)
    {
        return ($this->hasAttribute($key) ? $this->attributes[$key] : null);
    }

    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    public function removeAttribute($key)
    {
        unset($this->attributes[$key]);
    }
}
