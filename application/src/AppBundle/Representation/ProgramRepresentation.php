<?php

namespace Playbloom\Trainer\AppBundle\Representation;

use Playbloom\Trainer\AppBundle\Entity\Program;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProgramRepresentation
{
    public $data;

    public function __construct(Program $program, UrlGeneratorInterface $urlGenerator)
    {
        $sessions = [];
        foreach ($program->getSessions() as $session) {
            $array = [];
            $array['data'] = $session->jsonSerialize();
            $array['links']['start'] = $urlGenerator->generate('report_create', ['session' => $session->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

            $sessions[] = $array;
        }

        $this->data = [
            'month' => $program->getMonth(),
            'sessions' => $sessions
        ];
    }
}