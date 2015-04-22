<?php

namespace AppBundle\Controller;

use Becklyn\RadBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


/**
 *
 */
class IndexController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return new Response("Becklyn web project");
    }
}
