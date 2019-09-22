<?php
/**
 * Created by PhpStorm.
 * User: robm
 * Date: 22/09/2019
 * Time: 12:40
 */

namespace App\Tests\JsonApi\Hydrator\Slot;


use App\Entity\Slot;
use App\JsonApi\Hydrator\Slot\CreateSlotHydrator;
use App\JsonApi\Hydrator\Slot\UpdateSlotHydrator;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use WoohooLabs\Yin\JsonApi\Exception\ExceptionFactoryInterface;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequest;

class UpdateSlotHydratorTest extends SlotHydratorTestCase
{

    public function testHydrateForUpdate() {

        $this->mock_json_api_request
            ->method('getResource')
            ->willReturn([
                'type' => 'slots',
                'id' => 'abc-234',
                'attributes' => [
                    'starts' => '2019-09-21T12:00:00+00:00',
                    'ends' => '2019-09-21T13:00:00+00:00',
                    'price'=> '20',
                    'currency' => 'GBP',
                    'available' => false
                ]
            ]);

        $this->mock_class_meta
            ->method('hasField')
            ->willReturn(true);

        $this->mock_class_meta
            ->method('getTypeOfField')
            ->willReturn('string');

        $this->mock_entity_manager
            ->method('getClassMetadata')
            ->willReturn($this->mock_class_meta);

        $this->mock_uuid_generator
            ->method('generate')
            ->willReturn('abc-234');

        $hydrator = new UpdateSlotHydrator($this->mock_entity_manager, $this->mock_exception_factory);

        $slot = $hydrator->hydrateForUpdate($this->mock_json_api_request, $this->mock_exception_factory, new Slot());

        $this->assertEquals('abc-234', $slot->getId());
        $this->assertEquals(new \DateTime('2019-09-21T12:00:00+00:00'), $slot->getStarts());
        $this->assertEquals(new \DateTime('2019-09-21T13:00:00+00:00'), $slot->getEnds());
        $this->assertEquals('20', $slot->getPrice());
        $this->assertEquals('GBP', $slot->getCurrency());
        $this->assertEquals(false, $slot->getAvailable());
    }
}