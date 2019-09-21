<?php

namespace App\JsonApi\Hydrator\Pitch;

use App\Entity\Pitch;

/**
 * Update Pitch Hydrator.
 */
class UpdatePitchHydrator extends AbstractPitchHydrator
{
    /**
     * {@inheritdoc}
     */
    protected function getAttributeHydrator($pitch): array
    {
        return [
            'name' => function (Pitch $pitch, $attribute, $data, $attributeName) {
                $pitch->setName($attribute);
            },
            'sport' => function (Pitch $pitch, $attribute, $data, $attributeName) {
                $pitch->setSport($attribute);
            },
        ];
    }
}
