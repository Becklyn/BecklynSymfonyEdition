<?php

require_once __DIR__.'/../app/BecklynSymfony/LocalAccess.php';

use BecklynSymfony\LocalAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
$localAccess = new LocalAccess($_SERVER);
if (!$localAccess->allowLocalAccess())
{
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
