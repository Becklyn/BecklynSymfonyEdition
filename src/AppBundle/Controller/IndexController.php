<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 *
 */
class IndexController extends Controller
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
