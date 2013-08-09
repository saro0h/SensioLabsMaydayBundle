<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
use SensioLabs\Connect\Api\Entity\User;

class SlnController extends BaseController
{
    /**
     * @Conf\Route("/sln_customiser.js", name="sensiolabs_mayday_sln")
     * @Conf\Template("SensioLabsMaydayBundle:Sln:index.js.twig")
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getApiUser();

        if (!$user instanceof User) {
            $user = null;
        }

        return array('user' => $user);
    }

    /**
     * @Conf\Route("/session/callback", name="oauth_callback")
     */
    public function newSessionAction(Request $request)
    {
        return $this->get('security.authentication.entry_point.sensiolabs_connect')->start($request);
    }
}