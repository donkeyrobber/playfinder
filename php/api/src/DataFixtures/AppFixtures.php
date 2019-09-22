<?php

namespace App\DataFixtures;

use App\Entity\Pitch;
use App\Entity\Slot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $pitch = new Pitch();
        $pitch->setName('Tonbridge Sports Ground');
        $pitch->setSport('Football');
        $manager->persist($pitch);

        $slot = new Slot();
        $slot->setId('abc-123');
        $slot->setPitch($pitch);
        $slot->setStarts(new \DateTime('2019-09-21 08:00:00'));
        $slot->setEnds(new \DateTime('2019-09-21 09:00:00'));
        $slot->setPrice('20.00');
        $slot->setCurrency('GBP');
        $slot->setAvailable(true);
        $manager->persist($slot);

        $slot = new Slot();
        $slot->setId('abc-124');
        $slot->setPitch($pitch);
        $slot->setStarts(new \DateTime('2019-09-21 09:00:00'));
        $slot->setEnds(new \DateTime('2019-09-21 10:00:00'));
        $slot->setPrice('20.00');
        $slot->setCurrency('GBP');
        $slot->setAvailable(false);
        $manager->persist($slot);

        $slot = new Slot();
        $slot->setId('abc-125');
        $slot->setPitch($pitch);
        $slot->setStarts(new \DateTime('2019-09-21 10:00:00'));
        $slot->setEnds(new \DateTime('2019-09-21 11:00:00'));
        $slot->setPrice('25.00');
        $slot->setCurrency('GBP');
        $slot->setAvailable(true);
        $manager->persist($slot);

        $pitch = new Pitch();
        $pitch->setName('Tonbridge Boys School');
        $pitch->setSport('Squash');
        $manager->persist($pitch);

        $slot = new Slot();
        $slot->setId('abc-126');
        $slot->setPitch($pitch);
        $slot->setStarts(new \DateTime('2019-09-21 08:00:00'));
        $slot->setEnds(new \DateTime('2019-09-21 09:00:00'));
        $slot->setPrice('9.00');
        $slot->setCurrency('GBP');
        $slot->setAvailable(true);
        $manager->persist($slot);

        $slot = new Slot();
        $slot->setId('abc-127');
        $slot->setPitch($pitch);
        $slot->setStarts(new \DateTime('2019-09-21 09:00:00'));
        $slot->setEnds(new \DateTime('2019-09-21 10:00:00'));
        $slot->setPrice('9.00');
        $slot->setCurrency('GBP');
        $slot->setAvailable(false);
        $manager->persist($slot);

        $slot = new Slot();
        $slot->setId('abc-128');
        $slot->setPitch($pitch);
        $slot->setStarts(new \DateTime('2019-09-21 11:00:00'));
        $slot->setEnds(new \DateTime('2019-09-21 12:00:00'));
        $slot->setPrice('9.00');
        $slot->setCurrency('GBP');
        $slot->setAvailable(true);
        $manager->persist($slot);
        $manager->flush();
    }
}
