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
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use WoohooLabs\Yin\JsonApi\Exception\ExceptionFactoryInterface;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequest;

class SlotHydratorTestCase extends TestCase
{
    protected $mock_entity_manager;
    protected $mock_exception_factory;
    protected $mock_json_api_request;
    protected $mock_class_meta;
    protected $mock_uuid_generator;

    public function setUp()
    {
        $this->mock_entity_manager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['getClassMetadata'])
            ->getMock();

        $this->mock_exception_factory = $this->getMockBuilder(ExceptionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mock_json_api_request = $this->getMockBuilder(JsonApiRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResource'])
            ->getMock();

        $this->mock_class_meta = $this->getMockBuilder(ClassMetadata::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasField', 'getTypeOfField'])
            ->getMockForAbstractClass();

        $this->mock_uuid_generator = $this->getMockBuilder(UuidGenerator::class)
            ->disableOriginalConstructor()
            ->setMethods(['generate'])
            ->getMock();
    }
}
