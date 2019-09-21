<?php

namespace App\JsonApi\Hydrator\Pitch;

use App\Entity\Pitch;

/**
 * Create Pitch Hydrator.
 */
class CreatePitchHydrator extends AbstractPitchHydrator
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
