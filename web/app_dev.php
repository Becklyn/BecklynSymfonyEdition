<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
$isLocalIp = function ($ip)
{
    if (!$ip)
    {
        return false;
    }

    if (in_array($ip, ['127.0.0.1', 'fe80::1', '::1']))
    {
        return true;
    }

    // allowed (= local) IPs include
    // 10.0.0.0 – 10.255.255.255
    // 172.16.0.0 – 172.31.255.255
    // 192.168.0.0 – 192.168.255.255
    return 1 === preg_match("/^(10\\.|192\\.168\\.|172\\.(1[6-9]|2[0-9]|3[0-1])\\.)/", $ip);
};

if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(php_sapi_name() === 'cli-server' || $isLocalIp($_SERVER['REMOTE_ADDR']))
) {
    header('HTTP/1.0 403 Forbidden');
    exit("Forbidden.");
}

$loader = require_once __DIR__.'/../var/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
