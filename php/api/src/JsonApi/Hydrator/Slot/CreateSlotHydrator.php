<?php

namespace App\JsonApi\Hydrator\Slot;

use App\Entity\Slot;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\UuidGenerator;
use WoohooLabs\Yin\JsonApi\Exception\ExceptionFactoryInterface;

/**
 * Create Slot Hydrator.
 */
class CreateSlotHydrator extends AbstractSlotHydrator
{
    private $uuid_generator;

    public function __construct( ObjectManager $object_manager, ExceptionFactoryInterface $exception_factory, UuidGenerator $uuid_generator)
    {
        $this->uuid_generator = $uuid_generator;

        parent::__construct($object_manager, $exception_factory);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeHydrator($slot): array
    {
        return [
            'starts' => function (Slot $slot, $attribute, $data, $attributeName) {
                $slot->setStarts(new \DateTime($attribute));
            },
            'ends' => function (Slot $slot, $attribute, $data, $attributeName) {
                $slot->setEnds(new \DateTime($attribute));
            },
            'price' => function (Slot $slot, $attribute, $data, $attributeName) {
                $slot->setPrice($attribute);
            },
            'currency' => function (Slot $slot, $attribute, $data, $attributeName) {
                $slot->setCurrency($attribute);
            },
            'available' => function (Slot $slot, $attribute, $data, $attributeName) {
                $slot->setAvailable($attribute);
            },
        ];
    }

    protected function generateId(): string
    {
        return $this->uuid_generator->generate($this->objectManager, new Slot());
    }

    protected function setId($slot, string $id): Slot
    {
        $slot->setId($id);
        return $slot;
    }
}
