<?php

namespace App\JsonApi\Transformer;

use App\Entity\Slot;
use WoohooLabs\Yin\JsonApi\Schema\Link\ResourceLinks;
use WoohooLabs\Yin\JsonApi\Schema\Link\Link;
use WoohooLabs\Yin\JsonApi\Schema\Relationship\ToOneRelationship;
use WoohooLabs\Yin\JsonApi\Schema\Resource\AbstractResource;

/**
 * Slot Resource Transformer.
 */
class SlotResourceTransformer extends AbstractResource
{
    /**
     * {@inheritdoc}
     */
    public function getType($slot): string
    {
        return 'slots';
    }

    /**
     * {@inheritdoc}
     */
    public function getId($slot): string
    {
        return (string) $slot->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta($slot): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks($slot): ?ResourceLinks
    {
        return ResourceLinks::createWithoutBaseUri()->setSelf(new Link('/slots/'.$this->getId($slot)));
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes($slot): array
    {
        return [
            'starts' => function (Slot $slot) {
                return $slot->getStarts()->format(DATE_ATOM);
            },
            'ends' => function (Slot $slot) {
                return $slot->getEnds()->format(DATE_ATOM);
            },
            'price' => function (Slot $slot) {
                return $slot->getPrice();
            },
            'currency' => function (Slot $slot) {
                return $slot->getCurrency();
            },
            'available' => function (Slot $slot) {
                return $slot->getAvailable();
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultIncludedRelationships($slot): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getRelationships($slot): array
    {
        return [
            'pitch' => function (Slot $slot) {
                return ToOneRelationship::create()
                    ->setDataAsCallable(
                        function () use ($slot) {
                            return $slot->getPitch();
                        },
                        new PitchResourceTransformer()
                    )
                    ->omitDataWhenNotIncluded();
            },
        ];
    }
}
