<?php

namespace App\JsonApi\Transformer;

use App\Entity\Pitch;
use WoohooLabs\Yin\JsonApi\Schema\Link\ResourceLinks;
use WoohooLabs\Yin\JsonApi\Schema\Link\Link;
use WoohooLabs\Yin\JsonApi\Schema\Relationship\ToManyRelationship;
use WoohooLabs\Yin\JsonApi\Schema\Resource\AbstractResource;

/**
 * Pitch Resource Transformer.
 */
class PitchResourceTransformer extends AbstractResource
{
    /**
     * {@inheritdoc}
     */
    public function getType($pitch): string
    {
        return 'pitches';
    }

    /**
     * {@inheritdoc}
     */
    public function getId($pitch): string
    {
        return (string) $pitch->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta($pitch): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks($pitch): ?ResourceLinks
    {
        return ResourceLinks::createWithoutBaseUri()->setSelf(new Link('/pitches/'.$this->getId($pitch)));
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes($pitch): array
    {
        return [
            'name' => function (Pitch $pitch) {
                return $pitch->getName();
            },
            'sport' => function (Pitch $pitch) {
                return $pitch->getSport();
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultIncludedRelationships($pitch): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getRelationships($pitch): array
    {
        return [
            'slots' => function (Pitch $pitch) {
                return ToManyRelationship::create()
                    ->setDataAsCallable(
                        function () use ($pitch) {
                            return $pitch->getSlots();
                        },
                        new SlotResourceTransformer()
                    )
                    ->omitDataWhenNotIncluded();
            },
        ];
    }
}
