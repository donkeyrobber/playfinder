<?php
/**
 * Created by PhpStorm.
 * User: robm
 * Date: 20/09/2019
 * Time: 21:53
 */

namespace App\Tests\Controller;


use App\Controller\PitchController;
use App\Tests\DataFixtureTestCase;
use Psr\Http\Message\ResponseInterface;
use WoohooLabs\Yin\JsonApi\JsonApi;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequestInterface;

class PitchControllerTest extends DataFixtureTestCase
{

    public function testGetPitches() {
        $this->client->request('GET', '/pitches/');
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $expected_data = [
            [
                'type' => 'pitches',
                'id' => '1',
                'links' => [
                    'self' => '/pitches/1'
                ],
                'attributes' => [
                    'name' => 'Tonbridge Sports Ground',
                    'sport' => 'Football'
                ]
            ],
            [
                'type' => 'pitches',
                'id' => '2',
                'links' => [
                    'self' => '/pitches/2'
                ],
                'attributes' => [
                    'name' => 'Tonbridge Boys School',
                    'sport' => 'Squash'
                ]
            ],
        ];

        $this->assertEquals(
            $expected_data,
            $response['data']
        );
    }

    public function testGetPitch() {
        $this->client->request('GET', '/pitches/1');
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $expected_data = [
            'type' => 'pitches',
            'id' => '1',
            'links' => [
                'self' => '/pitches/1'
            ],
            'attributes' => [
                'name' => 'Tonbridge Sports Ground',
                'sport' => 'Football'
            ]
        ];

        $this->assertEquals(
            $expected_data,
            $response['data']
        );
    }

    public function testGetPitch404IfResourceNotFound() {
        $this->client->request('GET', '/pitches/11');
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testGetSlots() {
        $this->client->request('GET', '/pitches/1/slots');
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $expected_data = [
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
            ],
            [
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
            ],
        ];


        $this->assertEquals(
            $expected_data,
            $response['data']
        );
    }

    public function testPostSlots() {

        $payload = [
            'data' => [
                'type' => 'slots',
                'attributes' => [
                    'starts' => '2019-09-21 12:00:00',
                    'ends' => '2019-09-21 13:00:00',
                    'price'=> '20',
                    'currency' => 'GBP',
                    'available' => 'false'
                ]
            ]
        ];

        $this->client->request(
            'POST',
            '/pitches/1/slots',
            [],
            [],
            [],
            json_encode($payload)
        );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}