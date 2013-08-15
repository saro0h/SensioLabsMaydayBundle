<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
use SensioLabs\Connect\Security\Authentication\Token\ConnectToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Connect controller.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @Conf\Route("/connect")
 */
class ConnectController extends BaseController
{
    /**
     * Connect customiser action.
     *
     * @Conf\Route("/customiser", name="mayday_connect_customiser")
     * @Conf\Template("SensioLabsMaydayBundle:Connect:customiser.js.twig")
     *
     * @return array
     */
    public function customiserAction()
    {
        $token = $this->get('security.context')->getToken();
        $user = $token instanceof ConnectToken ? $token->getApiUser() : null;

    	return array('user' => $user);
    }

    /**
     * Connect callback action.
     *
     * @Conf\Route("/callback", name="mayday_connect_callback")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function callbackAction(Request $request)
    {
        return $this
            ->get('security.authentication.entry_point.sensiolabs_connect')
            ->start($request);
    }
}
