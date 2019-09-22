<?php
/**
 * Created by PhpStorm.
 * User: robm
 * Date: 22/09/2019
 * Time: 16:24
 */

namespace App\Tests\ResourceCollection;


use App\ResourceCollection\SlotCollection;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class SlotCollectionTest extends TestCase
{
    public function testSlotCollectionAddItem() {
        $slot_array = [
            [
                'type' => 'slots',
                'id' => 'abc-123',
                'links' => [
                    'self' => '/slots/abc-123'
                ],
                'attributes' => [
                    'starts' => '2019-09-21T08:00:00+00:00',
                    'ends' => '2019-09-21T09:00:00+00:00',
                    'price'=> '20',
                    'currency' => 'GBP',
                    'available' => true
                ]
            ],
            [
                'type' => 'slots',
                'id' => 'abc-124',
                'links' => [
                    'self' => '/slots/abc-124'
                ],
                'attributes' => [
                    'starts' => '2019-09-21T09:00:00+00:00',
                    'ends' => '2019-09-21T10:00:00+00:00',
                    'price'=> '20',
                    'currency' => 'GBP',
                    'available' => false
                ]
            ]
        ];

        $slot_collection = new SlotCollection($slot_array);

        $new_slot = [
            'type' => 'slots',
            'id' => 'abc-125',
            'links' => [
                'self' => '/slots/abc-125'
            ],
            'attributes' => [
                'starts' => '2019-09-21T10:00:00+00:00',
                'ends' => '2019-09-21T11:00:00+00:00',
                'price'=> '25',
                'currency' => 'GBP',
                'available' => true
            ]
        ];

        $slot_collection->addItem($new_slot);

        $slot_iterator = $slot_collection->getIterator();

        $this->assertEquals(3, $slot_iterator->count());
        $slot_iterator->seek(2);
        $this->assertEquals($new_slot, $slot_iterator->current());
    }
}