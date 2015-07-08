<?php

namespace AppBundle\Controller;

use Becklyn\RadBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;


/**
 *
 */
class IndexController extends BaseController
{
    /**
     * Displays the homepage
     */
    public function homepageAction()
    {
        return new Response("Becklyn web project");
    }
}
