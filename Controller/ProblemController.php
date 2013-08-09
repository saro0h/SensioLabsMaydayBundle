<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
use Symfony\Component\HttpFoundation\Request;
use SensioLabs\Connect\Security\EntryPoint\ConnectEntryPoint;

/*
 * @author Sarah Khalil <sarah.khalil@sensiolabs.com>
 */
class ProblemController extends Controller
{
    /**
     * @Conf\Route("/")
     * @Conf\Template()
     */
    public function listAction()
    {
        return array();
    }

    /**
     * @Conf\Route("/create")
     * @Conf\Template()
     */
    public function createAction()
    {
        return array();
    }
}
