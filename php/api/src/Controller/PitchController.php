<?php
/**
 * Created by PhpStorm.
 * User: robm
 * Date: 20/09/2019
 * Time: 21:16
 */

namespace App\Controller;

use App\Entity\Pitch;
use App\Entity\Slot;
use App\JsonApi\Document\Pitch\PitchDocument;
use App\JsonApi\Document\Pitch\PitchesDocument;
use App\JsonApi\Document\Slot\SlotDocument;
use App\JsonApi\Document\Slot\SlotsDocument;
use App\JsonApi\Hydrator\Slot\CreateSlotHydrator;
use App\JsonApi\Transformer\PitchResourceTransformer;
use App\JsonApi\Transformer\SlotResourceTransformer;
use App\Repository\PitchRepository;
use App\Repository\SlotRepository;
use App\ResourceCollection\SlotCollection;
use Doctrine\ORM\Id\UuidGenerator;
use Paknahad\JsonApiBundle\Controller\Controller;
use Paknahad\JsonApiBundle\Helper\ResourceCollection;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use WoohooLabs\Yin\JsonApi\Exception\DefaultExceptionFactory;

/**
 * @Route("/pitches")
 */

class PitchController extends Controller
{
    /**
     * @Route("/", name="get_pitches", methods="GET")
     */
    public function getPitchesAction(PitchRepository $pitch_repository, ResourceCollection $resource_collection): ResponseInterface
    {
        $resource_collection->setRepository($pitch_repository);

        $resource_collection->handleIndexRequest();

        return $this->jsonApi()->respond()->ok(
            new PitchesDocument(new PitchResourceTransformer()),
            $resource_collection
        );

    }

    /**
     * @Route("/{id}", name="get_pitch", methods="GET")
     */
    public function getPitchAction(Pitch $pitch): ResponseInterface
    {
        return $this->jsonApi()->respond()->ok(
            new PitchDocument(new PitchResourceTransformer()),
            $pitch
        );
    }

    /**
     * @Route("/{id}/slots", name="get_slots", methods="GET")
     */
    public function getSlotsAction(SlotRepository $slot_repository): ResponseInterface
    {
        $pitch_id = $this->jsonApi()->getRequest()->getAttribute('id');

        $slot_collection = new SlotCollection($slot_repository->findBy(['pitch' => $pitch_id] ));

        return $this->jsonApi()->respond()->ok(new SlotsDocument(new SlotResourceTransformer()),
            $slot_collection);
    }

    /**
     * @Route("/{id}/slots", name="post_slots", methods="POST")
     */
    public function postSlotsAction(ValidatorInterface $validator, PitchRepository $pitch_repository, UuidGenerator $uuid_generator, DefaultExceptionFactory $exception_factory): ResponseInterface
    {
        $pitch_id = $this->jsonApi()->getRequest()->getAttribute('id');

        $pitch = $pitch_repository->find($pitch_id);

        $entity_manager = $this->getDoctrine()->getManager();

        $slot = $this->jsonApi()->hydrate(new CreateSlotHydrator($entity_manager, $exception_factory, $uuid_generator), new Slot());

        $slot->setPitch($pitch);

        /** @var ConstraintViolationList $errors */
        $errors = $validator->validate($slot);
        if ($errors->count() > 0) {
            return $this->validationErrorResponse($errors);
        }

        $entity_manager->persist($slot);
        $entity_manager->flush();

        return $this->jsonApi()->respond()->ok(
            new SlotDocument(new SlotResourceTransformer()),
            $slot
        );
    }
}