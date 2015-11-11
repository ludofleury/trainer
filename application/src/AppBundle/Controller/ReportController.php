<?php

namespace Playbloom\Trainer\AppBundle\Controller;

use Playbloom\Trainer\AppBundle\Entity\Report;
use Playbloom\Trainer\AppBundle\Form\FormErrorSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Playbloom\Trainer\AppBundle\Entity\Session;
use Playbloom\Trainer\AppBundle\Form\Type\ExerciseType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ReportController extends Controller
{
    /**
     * @Method({"POST"})
     * @Route("/sessions/{session}/reports", name="report_create")
     *
     * @ParamConverter("session", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Session", options={"repository_method"="find"})
     */
    public function createAction(Session $session, Request $request)
    {
        $report = new Report();
        $report->setSession($session);
        $report->setDate(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($report);
        $entityManager->flush();

        $nextExercise = $session->getExercises()->first();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_CREATED,
            [
                'Links' => $this->generateUrl(
                    'feedback_create',
                    ['report' => $report->getId(), 'exercise' => $nextExercise->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL)
            ]
        );
    }

    /**
     * @Method({"DELETE"})
     * @Route("/reports/{report}", name="report_delete")
     *
     * @ParamConverter("report", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Report", options={"repository_method"="find"})
     */
    public function deleteAction(Report $report)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($report);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}