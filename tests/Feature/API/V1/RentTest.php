<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Driver;
use App\Models\Rent;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RentTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('createRentDataProvider')]
    public function testCreateRent(
        array  $payload,
        int    $expectedStatus,
        ?array $expectedJsonStructure = null,
        ?array $expectedDatabaseData = null,
        ?array $expectedValidationErrors = null
    ): void {
        if ($expectedStatus === 201) {
            $driver = Driver::factory()->create();
            $vehicle = Vehicle::factory()->create();
            $payload['driverId'] = $driver->id;
            $payload['vehicleId'] = $vehicle->id;
        }

        $response = $this->postJson('/api/v1/rent/create', $payload);

        $response->assertStatus($expectedStatus);

        if ($expectedValidationErrors) {
            foreach ($expectedValidationErrors as $field => $message) {
                $response->assertJsonValidationErrors($field);
                $errors = $response->json('errors');
                $this->assertEquals($message, $errors[$field][0]);
            }
        }

        if ($expectedJsonStructure) {
            $response->assertJsonStructure($expectedJsonStructure);
        }

        if ($expectedDatabaseData) {
            $this->assertDatabaseHas('rents', $expectedDatabaseData);
        }
    }

    public static function createRentDataProvider(): iterable
    {
        return [
            'successfulCreation' => [
                'payload' => [
                    'offerId'       => 'test-offer-123',
                    'locationStart' => '37.123, 55.123',
                    'context'       => ['test' => 'value'],
                ],
                'expectedStatus'        => 201,
                'expectedJsonStructure' => [
                    'data' => [
                        'id',
                        'vehicle_id',
                        'driver_id',
                        'offer_id',
                        'status',
                        'is_active',
                        'is_allowed_zone_left',
                        'cost_total',
                    ],
                ],
                'expectedDatabaseData' => [
                    'offer_id'  => 'test-offer-123',
                    'status'    => 'reserve',
                    'is_active' => true,
                ],
                'expectedValidationErrors' => null,
            ],
            'invalidVehicleAndDriverIds' => [
                'payload' => [
                    'vehicleId'     => 1,
                    'driverId'      => 1,
                    'offerId'       => 'test-offer-123',
                    'locationStart' => '37.123, 55.123',
                    'context'       => ['test' => 'value'],
                ],
                'expectedStatus'           => 422,
                'expectedJsonStructure'    => null,
                'expectedDatabaseData'     => null,
                'expectedValidationErrors' => [
                    'vehicleId' => 'The selected vehicle id is invalid.',
                    'driverId'  => 'The selected driver id is invalid.',
                ],
            ],
            'invalidLocationFormat' => [
                'payload' => [
                    'vehicleId'     => 1,
                    'driverId'      => 1,
                    'offerId'       => 'test-offer-123',
                    'locationStart' => 'invalid-format',
                    'context'       => ['test' => 'value'],
                ],
                'expectedStatus'           => 422,
                'expectedJsonStructure'    => null,
                'expectedDatabaseData'     => null,
                'expectedValidationErrors' => [
                    'locationStart' => 'The location start field format is invalid.',
                ],
            ],
            'invalidContextType' => [
                'payload' => [
                    'vehicleId'     => 1,
                    'driverId'      => 1,
                    'offerId'       => 'test-offer-123',
                    'locationStart' => '37.123, 55.123',
                    'context'       => 'not-an-array',
                ],
                'expectedStatus'           => 422,
                'expectedJsonStructure'    => null,
                'expectedDatabaseData'     => null,
                'expectedValidationErrors' => [
                    'context' => 'The context field must be an array.',
                ],
            ],
            'emptyOfferId' => [
                'payload' => [
                    'vehicleId'     => 1,
                    'driverId'      => 1,
                    'offerId'       => '',
                    'locationStart' => '37.123, 55.123',
                    'context'       => ['test' => 'value'],
                ],
                'expectedStatus'           => 422,
                'expectedJsonStructure'    => null,
                'expectedDatabaseData'     => null,
                'expectedValidationErrors' => [
                    'offerId' => 'The offer id field is required.',
                ],
            ],
        ];
    }

    #[DataProvider('changeRentStatusDataProvider')]
    public function testChangeRentStatus(
        string  $initialStatus,
        string  $targetStatus,
        int     $expectedStatus,
        ?string $expectedFinalStatus = null
    ): void {
        $rent = Rent::factory()->create(['status' => $initialStatus]);

        $response = $this->patchJson('/api/v1/rent/change-status', [
            'rentId'       => $rent->id,
            'targetStatus' => $targetStatus,
        ]);

        $response->assertStatus($expectedStatus);

        if ($expectedFinalStatus) {
            $this->assertDatabaseHas('rents', [
                'id'     => $rent->id,
                'status' => $expectedFinalStatus,
            ]);
        }
    }

    public static function changeRentStatusDataProvider(): iterable
    {
        return [
            'successfulStatusChange' => [
                'initialStatus'       => 'reserve',
                'targetStatus'        => 'driving',
                'expectedStatus'      => 200,
                'expectedFinalStatus' => 'driving',
            ],
            'invalidStatusChange' => [
                'initialStatus'       => 'reserve',
                'targetStatus'        => 'invalid_status',
                'expectedStatus'      => 422,
                'expectedFinalStatus' => null,
            ],
        ];
    }

    #[DataProvider('getRentHistoryDataProvider')]
    public function testGetRentHistory(
        int    $rentsCount,
        array  $queryParams,
        int    $expectedStatus,
        ?array $expectedJsonStructure,
        ?int   $expectedListCount
    ): void {
        $driver = Driver::factory()->create();

        if ($rentsCount > 0) {
            Rent::factory()->count($rentsCount)->create([
                'driver_id' => $driver->id,
                'status'    => 'finished',
            ]);
        }

        if (isset($queryParams['driverId']) && $queryParams['driverId'] === 'VALID_DRIVER_ID') {
            $queryParams['driverId'] = $driver->id;
        }

        $queryString = http_build_query($queryParams);
        $response = $this->getJson("/api/v1/rent/history?{$queryString}");

        $response->assertStatus($expectedStatus);

        if ($expectedJsonStructure) {
            $response->assertJsonStructure($expectedJsonStructure);

            if ($expectedListCount > 0) {
                $responseData = $response->json('data.list');
                foreach ($responseData as $rent) {
                    $this->assertIsInt($rent['id']);
                    $this->assertIsInt($rent['vehicle_id']);
                    $this->assertIsInt($rent['driver_id']);

                    if ($rent['offer_id'] !== null) {
                        $this->assertIsString($rent['offer_id']);
                    }
                    $this->assertIsString($rent['status']);
                    $this->assertIsArray($rent['location_start']);
                    $this->assertEquals('Point', $rent['location_start']['type']);
                    $this->assertIsArray($rent['location_start']['coordinates']);
                    $this->assertCount(2, $rent['location_start']['coordinates']);
                    $this->assertIsNumeric($rent['location_start']['coordinates'][0]);
                    $this->assertIsNumeric($rent['location_start']['coordinates'][1]);
                    $this->assertIsNumeric($rent['cost_total']);
                    $this->assertIsString($rent['created_at']);
                    $this->assertIsString($rent['updated_at']);
                    $this->assertTrue(
                        is_array($rent['context']) || is_null($rent['context']),
                        'context should be either array or null'
                    );

                    $this->assertMatchesRegularExpression(
                        '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/',
                        $rent['created_at']
                    );

                    $this->assertContains(
                        $rent['status'],
                        ['reserve', 'driving', 'finished', 'failed']
                    );
                }
            }
        }

        if ($expectedListCount !== null) {
            $this->assertCount($expectedListCount, $response->json('data.list'));
        }
    }

    public static function getRentHistoryDataProvider(): iterable
    {
        return [
            'successfulHistoryFetch' => [
                'rentsCount'  => 5,
                'queryParams' => [
                    'driverId' => 'VALID_DRIVER_ID',
                    'limit'    => 10,
                    'offset'   => 0,
                ],
                'expectedStatus'        => 200,
                'expectedJsonStructure' => [
                    'data' => [
                        'list' => [
                            '*' => [
                                'id',
                                'vehicle_id',
                                'driver_id',
                                'offer_id',
                                'status',
                                'location_start',
                                'location_end',
                                'cost_total',
                                'created_at',
                                'updated_at',
                                'context',
                            ],
                        ],
                        'pagination' => [
                            'total',
                            'limit',
                            'offset',
                        ],
                    ],
                ],
                'expectedListCount' => 5,
            ],
            'emptyHistory' => [
                'rentsCount'  => 0,
                'queryParams' => [
                    'driverId' => 'VALID_DRIVER_ID',
                    'limit'    => 10,
                    'offset'   => 0,
                ],
                'expectedStatus'        => 200,
                'expectedJsonStructure' => [
                    'data' => [
                        'list'       => [],
                        'pagination' => [
                            'total',
                            'limit',
                            'offset',
                        ],
                    ],
                ],
                'expectedListCount' => 0,
            ],
        ];
    }
}
