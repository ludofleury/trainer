<?php

namespace Playbloom\Trainer\AppBundle\Controller;

use Playbloom\Trainer\AppBundle\Entity\Feedback;
use Playbloom\Trainer\AppBundle\Entity\Report;
use Playbloom\Trainer\AppBundle\Form\FormErrorSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Playbloom\Trainer\AppBundle\Entity\Exercise;
use Playbloom\Trainer\AppBundle\Form\Type\FeedbackType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FeedbackController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/feedbacks/{feedback}", name="program_show")
     *
     * @ParamConverter("feedback", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Feedback", options={"repository_method"="find"})
     */
    public function showAction(Feedback $feedback)
    {
        return new JsonResponse(
            new ProgramRepresentation($feedback, $this->container->get('router')->getGenerator()),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Method({"POST"})
     * @Route("/reports/{report}/{exercise}/feedbacks", name="feedback_create")
     *
     * @ParamConverter("report", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Report", options={"repository_method"="find"})
     * @ParamConverter("exercise", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Exercise", options={"repository_method"="find"})
     */
    public function createAction(Report $report, Exercise $exercise, Request $request)
    {
        $hasExercise = function($programmedExercises, $expectedExercise) {
            foreach ($programmedExercises as $programmedExercise) {
                if ($expectedExercise->getId() === $programmedExercise->getId()) {
                    return true;
                }
            }

            return false;
        };

        if (!$hasExercise($report->getSession()->getExercises(), $exercise)) {
            return new JsonResponse(['error' => 'The exercise is not planned in this session'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $feedback = new feedback();
        $feedback->setReport($report);
        $feedback->setExercise($exercise);

        $form = $this->createForm(new FeedbackType(), $feedback);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedback);
            $entityManager->flush();

            return new JsonResponse(null, JsonResponse::HTTP_CREATED, ['Location' => $this->generateUrl('feedback_show', ['feedback' => $feedback->getId()], UrlGeneratorInterface::ABSOLUTE_PATH)]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"PUT"})
     * @Route("/feedbacks/{feedback}", name="feedback_update")
     *
     * @ParamConverter("feedback", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Feedback", options={"repository_method"="find"})
     */
    public function updateAction(Feedback $feedback, Request $request)
    {
        $form = $this->createForm(new FeedbackType(), $feedback);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(null, JsonResponse::HTTP_OK, ['Location' => $this->generateUrl('feedback_show', ['feedback' => $feedback->getId()], UrlGeneratorInterface::ABSOLUTE_PATH)]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"DELETE"})
     * @Route("/feedbacks/{feedback}", name="feedback_delete")
     *
     * @ParamConverter("feedback", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Feedback", options={"repository_method"="find"})
     */
    public function deleteAction(Feedback $feedback)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($feedback);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}