<?php

namespace App\JsonApi\Hydrator\Pitch;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Pitch;
use Paknahad\JsonApiBundle\Hydrator\ValidatorTrait;
use Paknahad\JsonApiBundle\Hydrator\AbstractHydrator;
use WoohooLabs\Yin\JsonApi\Exception\ExceptionFactoryInterface;
use Doctrine\ORM\Query\Expr;
use WoohooLabs\Yin\JsonApi\Hydrator\Relationship\ToManyRelationship;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequestInterface;

/**
 * Abstract Pitch Hydrator.
 */
abstract class AbstractPitchHydrator extends AbstractHydrator
{
    use ValidatorTrait;

    /**
     * {@inheritdoc}
     */
    protected function validateClientGeneratedId(
        string $clientGeneratedId,
        JsonApiRequestInterface $request,
        ExceptionFactoryInterface $exceptionFactory
    ): void {
        if (!empty($clientGeneratedId)) {
            throw $exceptionFactory->createClientGeneratedIdNotSupportedException(
                $request,
                $clientGeneratedId
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
        return ['pitches'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeHydrator($pitch): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    protected function validateRequest(JsonApiRequestInterface $request): void
    {
        $this->validateFields($this->objectManager->getClassMetadata(Pitch::class), $request);
    }

    /**
     * {@inheritdoc}
     */
    protected function setId($pitch, string $id): void
    {
        if ($id && (string) $pitch->getId() !== $id) {
            throw new NotFoundHttpException('both ids in url & body bust be same');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getRelationshipHydrator($pitch): array
    {
        return [
            'slots' => function (Pitch $pitch, ToManyRelationship $slots, $data, $relationshipName) {
                $this->validateRelationType($slots, ['slots']);

                if (count($slots->getResourceIdentifierIds()) > 0) {
                    $association = $this->objectManager->getRepository('App\Entity\Slot')
                        ->createQueryBuilder('s')
                        ->where((new Expr())->in('s.id', $slots->getResourceIdentifierIds()))
                        ->getQuery()
                        ->getResult();

                    $this->validateRelationValues($association, $slots->getResourceIdentifierIds(), $relationshipName);
                } else {
                    $association = [];
                }

                if ($pitch->getSlots()->count() > 0) {
                    foreach ($pitch->getSlots() as $slot) {
                        $pitch->removeSlot($slot);
                    }
                }

                foreach ($association as $slot) {
                    $pitch->addSlot($slot);
                }
            },
        ];
    }
}
