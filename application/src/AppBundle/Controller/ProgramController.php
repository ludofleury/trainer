<?php

namespace Playbloom\Trainer\AppBundle\Controller;

use Playbloom\Trainer\AppBundle\Form\FormErrorSerializer;
use Playbloom\Trainer\AppBundle\Representation\ProgramRepresentation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Playbloom\Trainer\AppBundle\Entity\Program;
use Playbloom\Trainer\AppBundle\Form\Type\ProgramType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProgramController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/programs", name="program_index")
     */
    public function indexAction()
    {
        $programs = $this->getDoctrine()->getRepository('Playbloom\Trainer\AppBundle\Entity\Program')->findAll();

        return new JsonResponse($programs, JsonResponse::HTTP_OK);
    }

    /**
     * @Method({"GET"})
     * @Route("/programs/{program}", name="program_show")
     *
     * @ParamConverter("program", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Program", options={"repository_method"="find"})
     */
    public function showAction(Program $program)
    {
        return new JsonResponse(
            new ProgramRepresentation($program, $this->container->get('router')->getGenerator()),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Method({"POST"})
     * @Route("/programs", name="program_create")
     */
    public function createAction(Request $request)
    {
        $program = new Program();
        $form = $this->createForm(new ProgramType(), $program);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($program);
            $entityManager->flush();

            return new JsonResponse(null, JsonResponse::HTTP_CREATED, ['Location' => $this->generateUrl('program_show', ['program' => $program->getId()], UrlGeneratorInterface::ABSOLUTE_PATH)]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"PUT"})
     * @Route("/programs/{program}", name="program_update")
     *
     * @ParamConverter("program", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Program", options={"repository_method"="find"})
     */
    public function updateAction(Program $program, Request $request)
    {
        $form = $this->createForm(new ProgramType(), $program);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(null, JsonResponse::HTTP_OK, ['Location' => $this->generateUrl('program_show', ['program' => $program->getId()], UrlGeneratorInterface::ABSOLUTE_PATH)]);
        }

        return new JsonResponse(FormErrorSerializer::serialize($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Method({"DELETE"})
     * @Route("/programs/{program}", name="program_delete")
     *
     * @ParamConverter("program", converter="doctrine.orm", class="Playbloom\Trainer\AppBundle\Entity\Program", options={"repository_method"="find"})
     */
    public function deleteAction(Program $program)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($program);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
