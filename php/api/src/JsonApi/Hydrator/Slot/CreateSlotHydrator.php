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
    private $uuidGenerator;

    public function __construct( ObjectManager $objectManager, ExceptionFactoryInterface $exceptionFactory, UuidGenerator $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;

        parent::__construct($objectManager, $exceptionFactory);
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
        return $this->uuidGenerator->generate($this->objectManager, new Slot());
    }

    protected function setId($slot, string $id): Slot
    {
        $slot->setId($id);
        return $slot;
    }
}
