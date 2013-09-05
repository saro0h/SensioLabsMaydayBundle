<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default controller.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DefaultController extends Controller
{
    /**
     * Home application page.
     *
     * @Conf\Route("/", name="mayday_default_index")
     * @Conf\Template()
     *
     * @return array
     */
    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_CONNECT_USER')) {
            return $this->redirect($this->generateUrl('mayday_problem_activity'));
        }

        return array();
    }
}
