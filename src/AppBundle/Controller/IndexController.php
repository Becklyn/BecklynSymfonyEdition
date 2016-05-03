<?php

namespace AppBundle\Controller;

use Becklyn\RadBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


/**
 *
 */
class IndexController extends BaseController
{
    /**
     * Displays the homepage
     *
     * @Template()
     */
    public function homepageAction()
    {
        return [];
    }
}
