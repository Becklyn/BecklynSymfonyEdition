<?php

namespace BecklynSymfony;


/**
 * Checks whether a given call is in the local network.
 *
 * Used to prevent remote access to web/app_dev.php
 */
class LocalAccess
{
    /**
     * @var array
     */
    private $serverData;



    /**
     * @param array $serverData
     */
    public function __construct (array $serverData)
    {
        $this->serverData = $serverData;
    }



    /**
     * Returns whether local access should be allowed
     *
     * @return bool
     */
    public function allowLocalAccess ()
    {
        return !$this->isForwardedByProxy() && ($this->isInCli() || $this->isLocalIp());
    }



    /**
     * Returns whether the request was forwarded by a proxy
     *
     * @return bool
     */
    private function isForwardedByProxy ()
    {
        return isset($this->serverData['HTTP_CLIENT_IP']) || isset($this->serverData['HTTP_X_FORWARDED_FOR']);
    }


    /**
     * Returns whether the call is made from the CLI
     *
     * @return bool
     */
    private function isInCli ()
    {
        return 'cli-server' === php_sapi_name();
    }


    /**
     * Returns whether remote IP is a local one
     *
     * @return bool
     */
    private function isLocalIp ()
    {
        $ip = $this->serverData["REMOTE_ADDR"];

        if (!is_string($ip))
        {
            return false;
        }

        if (in_array($ip, ['127.0.0.1', 'fe80::1', '::1'], true))
        {
            return true;
        }

        // allowed (= local) IPs include
        // 10.0.0.0 – 10.255.255.255
        // 172.16.0.0 – 172.31.255.255
        // 192.168.0.0 – 192.168.255.255
        return 1 === preg_match("/^(10\\.|192\\.168\\.|172\\.(1[6-9]|2[0-9]|3[0-1])\\.)/", $ip);
    }
}
