<?php

namespace Playbloom\Trainer\AppBundle\Controller;

use Playbloom\Trainer\AppBundle\Form\FormErrorSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Playbloom\Trainer\AppBundle\Entity\Exercise;
use Playbloom\Trainer\AppBundle\Form\Type\ExerciseType;

class ExerciseController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/exercises", name="exercise_index")
     */
    public function indexAction()
    {
        $exercises = $this->getDoctrine()->getRepository('Playbloom\Trainer\AppBundle\Entity\Exercise')->findAll();

        return new JsonResponse($exercises, JsonResponse::HTTP_OK);
    }

    /**
     * @Method({"GET"})
     * @Route("/exercises/{exercise}", name="exercise_show")
     *
     * @ParamConverter("exercise", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Exercise", options={"repository_method"="find"})
     */
    public function showAction(Exercise $exercise)
    {
        return new JsonResponse($exercise, JsonResponse::HTTP_OK);
    }

    /**
     * @Method({"POST"})
     * @Route("/exercises", name="exercise_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new ExerciseType());

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $exercise = $form->getData();
            $entityManager->persist($exercise);
            $entityManager->flush();

            return new JsonResponse(null, JsonResponse::HTTP_CREATED, ['Location' => $this->generateUrl('exercise_show', ['exercise' => $exercise->getId()])]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"PUT"})
     * @Route("/exercises/{exercise}", name="exercise_update")
     *
     * @ParamConverter("exercise", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Exercise", options={"repository_method"="find"})
     */
    public function updateAction(Exercise $exercise, Request $request)
    {
        $form = $this->createForm(new ExerciseType(), $exercise);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(null, JsonResponse::HTTP_OK, ['Location' => $this->generateUrl('exercise_show', ['exercise' => $exercise->getId()])]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"DELETE"})
     * @Route("/exercises/{exercise}", name="exercise_delete")
     *
     * @ParamConverter("exercise", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Exercise", options={"repository_method"="find"})
     */
    public function deleteAction(Exercise $exercise)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($exercise);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
