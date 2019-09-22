<?php

namespace App\JsonApi\Hydrator\Slot;

use App\Entity\Slot;

/**
 * Update Slot Hydrator.
 */
class UpdateSlotHydrator extends AbstractSlotHydrator
{
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

    protected function setId($slot, string $id): Slot
    {
        $slot->setId($id);
        return $slot;
    }
}
