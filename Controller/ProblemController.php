<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use SensioLabs\Bundle\MaydayBundle\Entity\Genius;
use SensioLabs\Bundle\MaydayBundle\Entity\Problem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Sarah Khalil <sarah.khalil@sensiolabs.com>
 */
class ProblemController extends Controller
{
    /**
     * @Conf\Route("/welcome", name="sensiolabs_maday_welcome")
     * @Conf\Template()
     */
    public function welcomeAction()
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('sensiolabs_maday_problem_list'));
        }
        return array();
    }
    /**
     * @Conf\Route("/", name="sensiolabs_maday_problem_list")
     * @Conf\Template()
     */
    public function listAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('sensiolabs_maday_welcome'));
        }
        $creationForm = $this->createForm('sensiolabs_mayday_problem');

        return array(
            'creation_form' => $creationForm->createView(),
            'problems' => $this->getDoctrine()->getRepository('SensioLabsMaydayBundle:Problem')->findAll(),
        );
    }

    /**
     * @Conf\Route("/create", name="sensiolabs_maday_problem_create")
     * @Conf\Method("post")
     * @Conf\Template()
     */
    public function createAction()
    {
        $creationForm = $this->createForm('sensiolabs_mayday_problem')->submit($this->getRequest());

        if ($creationForm->isValid()) {
            $this->save(new Problem($creationForm->getData()));

            return $this->redirect($this->generateUrl('sensiolabs_maday_problem_list'));
        }

        return array('form' => $creationForm->createView());
    }

    /**
     * @Conf\Template()
     */
    public function showAction(Problem $problem)
    {
        $api = $this->get('sensiolabs_connect.api');

        $api->setAccessToken($this->container->get('security.context')->getToken()->getAccessToken());
        $agent = $problem->getAgent($api);
        $user = $this->get('security.context')->getToken()->getApiUser();
        return array('dto' => $problem->getDTO($api), 'problem' => $problem, 'agent' => $agent, 'admin' => $problem->isAdmin($user));
    }

    /**
     * @Conf\Route("/handle", name="sensiolabs_mayday_problem_handle")
     * @Conf\Method("post")
     */
    public function handleAction(Request $request)
    {
        $this->save($this->getProblem($request)->handle($this->getGenius($this->get('security.context')->getToken()->getApiUser()->get('uuid'))));

        return $this->redirect($this->generateUrl('sensiolabs_maday_problem_list'));
    }

    /**
     * @Conf\Route("/remove", name="sensiolabs_mayday_problem_remove")
     * @Conf\Method("post")
     */
    public function removeAction(Request $request)
    {
        $this->remove($this->getProblem($request)->handle($this->getGenius($this->get('security.context')->getToken()->getApiUser()->get('uuid'))));

        return $this->redirect($this->generateUrl('sensiolabs_maday_problem_list'));
    }

    /**
     * @Conf\Route("/reward", name="sensiolabs_mayday_problem_reward")
     * @Conf\Method("post")
     */
    public function rewardAction(Request $request)
    {
        $problem = $this->getProblem($request)->handle($this->getGenius($this->get('security.context')->getToken()->getApiUser()->get('uuid')));
        $this->save($problem->reward());
        $this->remove($problem);

        return $this->redirect($this->generateUrl('sensiolabs_maday_problem_list'));
    }

    /**
     * @param Problem $problem
     */
    private function save($object)
    {
        $this->getDoctrine()->getManager()->persist($object);
        $this->getDoctrine()->getManager()->flush();
    }

    /**
     * @param Problem $problem
     */
    private function remove(Problem $problem)
    {
        $this->getDoctrine()->getManager()->remove($problem);
        $this->getDoctrine()->getManager()->flush();
    }

    private function getGenius($uuid)
    {
        $repository = $this->getDoctrine()->getRepository('SensioLabsMaydayBundle:Genius');
        $genius = $repository->find($uuid);

        if (null === $genius) {
            $genius = new Genius($uuid);
            $this->getDoctrine()->getManager()->persist($genius);
            $this->getDoctrine()->getManager()->flush();
        }

        return $genius;
    }

    private function getProblem(Request $request)
    {
        $problem = $this->getDoctrine()->getRepository('SensioLabsMaydayBundle:Problem')->find($request->request->get('problem_id'));

        if (null === $problem) {
            throw new NotFoundHttpException(sprintf('No problem found with "%s" ID.', $request->request->get('problem_id')));
        }

        return $problem;
    }
}
