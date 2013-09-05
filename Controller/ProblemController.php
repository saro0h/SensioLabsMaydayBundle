<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
use SensioLabs\Bundle\MaydayBundle\Entity\Problem;
use SensioLabs\Bundle\MaydayBundle\Notifier\Notification;
use SensioLabs\Bundle\MaydayBundle\Repository\ProblemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Problem controller.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @Conf\Route("/problems")
 */
class ProblemController extends Controller
{
    /**
     * Activity action.
     *
     * @Conf\Route("/", name="mayday_problem_activity")
     * @Conf\Template()
     *
     * @return array
     */
    public function activityAction()
    {
        $problems = $this->getRepository()->listActiveOnes();

        return array('problems' => $problems);
    }

    /**
     * Archives action.
     *
     * @Conf\Route("/archives", name="mayday_problem_archives")
     * @Conf\Template()
     *
     * @return array
     */
    public function archivesAction()
    {
        $problems = $this->getRepository()->listArchivedOnes();

        return array('problems' => $problems);
    }

    /**
     * Problem creation action.
     *
     * @Conf\Route("/create", name="mayday_problem_create")
     * @Conf\Method("POST")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm('sensiolabs_mayday_problem')->submit($request);

        if ($form->isValid()) {
            $problem = new Problem($this->getUser(), $form->getData());
            $this->getRepository()->save($problem);

            return $this->notify(new Notification('problem.created', $problem->asArray()));
        }

        return new JsonResponse(array('status' => 'form_error', 'form' => $form->createView()));
    }

    /**
     * Problem handled action.
     *
     * @Conf\Route("/handle", name="mayday_problem_handle")
     * @Conf\Method("POST")
     *
     * @param Problem $problem
     *
     * @return Response
     */
    public function handleAction(Problem $problem)
    {
        $this->getRepository()->save($problem->handle($this->getUser()));

        return $this->notify(new Notification('problem.handled', $this->getUser()->asArray()));
    }

    /**
     * Problem rewarded action.
     *
     * @Conf\Route("/{id}/resolve", name="mayday_problem_reward")
     * @Conf\Method("POST")
     *
     * @param Problem $problem
     *
     * @return Response
     */
    public function rewardAction(Problem $problem)
    {
        $this->getRepository()->save($problem->reward($this->getUser()));

        return $this->notify(new Notification('problem.rewarded', $this->getUser()->asArray()));
    }

    /**
     * Problem canceled action.
     *
     * @Conf\Route("/cancel", name="mayday_problem_cancel")
     * @Conf\Method("POST")
     *
     * @param Problem $problem
     *
     * @return Response
     */
    public function cancelAction(Problem $problem)
    {
        $this->getRepository()->save($problem->cancel());

        return $this->notify(new Notification('problem.canceled'));
    }

    /**
     * Returns problem repository.
     *
     * @return ProblemRepository
     */
    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('SensioLabsMaydayBundle:Problem');
    }

    /**
     * Broadcasts a notification to clients.
     *
     * @param Notification $notification
     *
     * @return Response
     */
    private function notify(Notification $notification)
    {
        $this->get('sensiolabs_mayday.notifier')->notify($notification);

        return new Response(204);
    }
}
