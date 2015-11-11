<?php

namespace Playbloom\Trainer\AppBundle\Controller;

use Playbloom\Trainer\AppBundle\Form\FormErrorSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Playbloom\Trainer\AppBundle\Entity\Session;
use Playbloom\Trainer\AppBundle\Form\Type\ExerciseType;

class SessionController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/sessions", name="session_index")
     */
    public function indexAction()
    {
        $sessions = $this->getDoctrine()->getRepository('Playbloom\Trainer\AppBundle\Entity\Session')->findAll();

        return new JsonResponse($sessions, JsonResponse::HTTP_OK);
    }

    /**
     * @Method({"GET"})
     * @Route("/sessions/{session}", name="session_show")
     *
     * @ParamConverter("session", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Session", options={"repository_method"="find"})
     */
    public function showAction(Session $session)
    {
        return new JsonResponse($session, JsonResponse::HTTP_OK);
    }

    /**
     * @Method({"POST"})
     * @Route("/sessions", name="session_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new ExerciseType());

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return new JsonResponse(null, JsonResponse::HTTP_CREATED, ['Location' => $this->generateUrl('session_show', ['exercise' => $session->getId()])]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"PUT"})
     * @Route("/sessions/{session}", name="session_update")
     *
     * @ParamConverter("session", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Session", options={"repository_method"="find"})
     */
    public function updateAction(Session $session, Request $request)
    {
        $form = $this->createForm(new ExerciseType(), $session);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(null, JsonResponse::HTTP_OK, ['Location' => $this->generateUrl('session_show', ['exercise' => $session->getId()])]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"DELETE"})
     * @Route("/sessions/{session}", name="session_delete")
     *
     * @ParamConverter("session", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Session", options={"repository_method"="find"})
     */
    public function deleteAction(Session $session)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($session);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
