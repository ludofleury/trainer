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
use Playbloom\Trainer\AppBundle\Form\Type\SessionType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SessionController extends Controller
{
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
     * @Route("/programs/{program}/sessions", name="session_create")
     *
     * @ParamConverter("program", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Program", options={"repository_method"="find"})
     */
    public function createAction(Program $program, Request $request)
    {
        $session = new Session();
        $session->setProgram($program);
        $form = $this->createForm(new SessionType(), $session);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return new JsonResponse(null, JsonResponse::HTTP_CREATED, ['Location' => $this->generateUrl('session_show', ['session' => $session->getId()], UrlGeneratorInterface::ABSOLUTE_PATH)]);
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
        $form = $this->createForm(new SessionType(), $session);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(null, JsonResponse::HTTP_OK, ['Location' => $this->generateUrl('session_show', ['session' => $session->getId()], UrlGeneratorInterface::ABSOLUTE_PATH)]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"DELETE"})
     * @Route("/programs/{program}/sessions/{session}", name="session_delete")
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
