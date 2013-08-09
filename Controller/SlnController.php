<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
use SensioLabs\Connect\Api\Entity\User;
use SensioLabs\Connect\Security\Authentication\Token\ConnectToken;

class SlnController extends BaseController
{
    /**
     * @Conf\Route("/sln_customiser.js", name="sln_customize")
     * @Conf\Template("SensioLabsMaydayBundle:Sln:index.js.twig")
     */
    public function indexAction()
    {
        $token = $this->get('security.context')->getToken();
        
        //$user = $token instanceof ConnectToken ? $token->getApiUser() : null;

        if ($token instanceof ConnectToken) {
        	return array('user' => $token->getApiUser());
        }

    	return array('user' => null);
    }

    /**
     * @Conf\Route("/session/callback", name="oauth_callback")
     */
    public function newSessionAction(Request $request)
    {
        return $this->get('security.authentication.entry_point.sensiolabs_connect')->start($request);
    }
}
