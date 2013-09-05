<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
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
     * Connect callback action.
     *
     * @Conf\Route("/callback", name="oauth_callback")
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
