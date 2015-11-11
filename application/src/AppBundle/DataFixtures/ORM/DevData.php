<?php

namespace Playbloom\Trainer\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Playbloom\Trainer\AppBundle\Entity;

class DevData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $exercise1 = new Entity\Exercise();
        $exercise1->setName('First exo');
        $exercise1->setReps(10);
        $exercise1->setSets(3);
        $exercise1->setRest(90);
        $exercise1->setDescription("First desc");
        $manager->persist($exercise1);

        $exercise2 = new Entity\Exercise();
        $exercise2->setName('Second exo');
        $exercise2->setReps(8);
        $exercise2->setSets(4);
        $exercise2->setRest(60);
        $exercise2->setDescription("Second desc");
        $manager->persist($exercise2);

        $session1 = new Entity\Session();
        $session1->setDay(1);
        $session1->setExercises([$exercise1, $exercise2]);
        $manager->persist($session1);

        $exercise3 = new Entity\Exercise();
        $exercise3->setName('First exo #2');
        $exercise3->setReps(10);
        $exercise3->setSets(3);
        $exercise3->setRest(90);
        $exercise3->setDescription("First desc #2");
        $manager->persist($exercise3);

        $exercise4 = new Entity\Exercise();
        $exercise4->setName('Second exo #2');
        $exercise4->setReps(8);
        $exercise4->setSets(4);
        $exercise4->setRest(60);
        $exercise4->setDescription("Second desc #2");
        $manager->persist($exercise4);

        $session2 = new Entity\Session();
        $session2->setDay(2);
        $session2->setExercises([$exercise3, $exercise4]);
        $manager->persist($session2);

        $program = new Entity\Program();
        $program->setMonth(1);
        $program->addSession($session1);
        $program->addSession($session2);
        $manager->persist($program);

        $manager->flush();
    }
}