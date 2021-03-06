<?php

namespace App\JsonApi\Hydrator\Slot;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Slot;
use Paknahad\JsonApiBundle\Hydrator\ValidatorTrait;
use Paknahad\JsonApiBundle\Hydrator\AbstractHydrator;
use WoohooLabs\Yin\JsonApi\Exception\ExceptionFactoryInterface;
use WoohooLabs\Yin\JsonApi\Hydrator\Relationship\ToOneRelationship;
use Paknahad\JsonApiBundle\Exception\InvalidRelationshipValueException;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequestInterface;

/**
 * Abstract Slot Hydrator.
 */
abstract class AbstractSlotHydrator extends AbstractHydrator
{
    use ValidatorTrait;

    /**
     * {@inheritdoc}
     */
    protected function validateClientGeneratedId(
        string $client_generated_id,
        JsonApiRequestInterface $request,
        ExceptionFactoryInterface $exception_factory
    ): void {
        if (!empty($clientGeneratedId)) {
            throw $exception_factory->createClientGeneratedIdNotSupportedException(
                $request,
                $client_generated_id
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function generateId(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    protected function getAcceptedTypes(): array
    {
        return ['slots'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeHydrator($slot): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    protected function validateRequest(JsonApiRequestInterface $request): void
    {
        $this->validateFields($this->objectManager->getClassMetadata(Slot::class), $request);
    }

    /**
     * {@inheritdoc}
     */
    protected function setId($slot, string $id): Slot
    {
        if ($id && (string) $slot->getId() !== $id) {
            throw new NotFoundHttpException('both ids in url & body bust be same');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getRelationshipHydrator($slot): array
    {
        return [
            'pitch' => function (Slot $slot, ToOneRelationship $pitch, $data, $relationship_name) {
                $this->validateRelationType($pitch, ['pitches']);


                $association = null;
                $identifier = $pitch->getResourceIdentifier();
                if ($identifier) {
                    $association = $this->objectManager->getRepository('App\Entity\Pitch')
                        ->find($identifier->getId());

                    if (is_null($association)) {
                        throw new InvalidRelationshipValueException($relationship_name, [$identifier->getId()]);
                    }
                }

                $slot->setPitch($association);
            },
        ];
    }
}
