<?php

namespace SensioLabs\Bundle\MaydayBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Conf;
use SensioLabs\Bundle\MaydayBundle\Entity\Problem;
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
     * @Conf\Route("/")
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
     * @Conf\Route("/archive")
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
     * @Conf\Route("/create")
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

            return $this->broadcastResponse('problem_created', $problem->asArray());
        }

        return new JsonResponse(array('status' => 'form_error', 'form' => $form->createView()));
    }

    /**
     * Problem handled action.
     *
     * @Conf\Route("/handle")
     * @Conf\Method("POST")
     *
     * @param Problem $problem
     *
     * @return JsonResponse
     */
    public function handleAction(Problem $problem)
    {
        $this->getRepository()->save($problem->handle($this->getUser()));

        return $this->broadcastResponse('problem_handled', $this->getUser()->asArray());
    }

    /**
     * Problem resolved action.
     *
     * @Conf\Route("/{id}/resolve")
     * @Conf\Method("POST")
     *
     * @param Problem $problem
     *
     * @return JsonResponse
     */
    public function resolveAction(Problem $problem)
    {
        $this->getRepository()->save($problem->resolve($this->getUser()));

        return $this->broadcastResponse('problem_resolved', $this->getUser()->asArray());
    }

    /**
     * Problem resolved action.
     *
     * @Conf\Route("/cancel")
     * @Conf\Method("POST")
     *
     * @param Problem $problem
     *
     * @return JsonResponse
     */
    public function cancelAction(Problem $problem)
    {
        $this->getRepository()->save($problem->cancel());

        return $this->broadcastResponse('problem_canceled');
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
     * Broadcasts a message and returns an empty response.
     *
     * @param string $type
     * @param array  $data
     *
     * @return Response
     */
    private function broadcastResponse($type, array $data = array())
    {
        $this->get('sensiolabs_mayday.react.remote')->broadcast($type, $data);

        return new Response(204);
    }
}
