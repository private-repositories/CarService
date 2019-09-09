<?php declare(strict_types=1);

namespace DavegTheMighty\CarService\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use DavegTheMighty\CarService\Model\Owner;
use DavegTheMighty\CarService\Model\Vehicle;

final class VehicleTest extends TestCase
{
    private $object;

    protected function setUp() : void
    {
        parent::setUp();
        $this->object = new Vehicle();
    }

    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            Vehicle::class,
            $this->object
        );
    }
    public function testVehicleFuelTypes(): void
    {
        $this->assertEquals($this->object::FUEL_TYPES, ['petrol', 'diesel']);

        $this->assertEquals($this->object::FUEL_TYPE_PETROL, 'petrol');
        $this->assertEquals($this->object::FUEL_TYPE_DIESEL, 'diesel');

        $this->assertCount(2, $this->object::FUEL_TYPES);
    }

    public function testVehicleTransmissionTypes(): void
    {
        $this->assertEquals($this->object::TRANSMISSION_TYPES, ['automatic', 'manual']);

        $this->assertEquals($this->object::TRANSMISSION_TYPE_MANUAL, 'manual');
        $this->assertEquals($this->object::TRANSMISSION_TYPE_AUTOMATIC, 'automatic');

        $this->assertCount(2, $this->object::TRANSMISSION_TYPES);
    }

    public function testFillableFields(): void
    {
        $fillable = $this->object->getFillable();
        $this->assertCount(10, $fillable);

        $this->assertContains("id", $fillable);
        $this->assertContains("license_plate", $fillable);
        $this->assertContains("year_of_purchase", $fillable);
        $this->assertContains("colour", $fillable);
        $this->assertContains("fuel_type", $fillable);
        $this->assertContains("transmission", $fillable);
        $this->assertContains("manufacturer", $fillable);
        $this->assertContains("model", $fillable);
        $this->assertContains("num_seats", $fillable);
        $this->assertContains("num_doors", $fillable);

        $this->assertNotContains("created_at", $fillable);
        $this->assertNotContains("updated_at", $fillable);
    }

    public function testHiddenFields(): void
    {
        $hidden = $this->object->getHidden();
        $this->assertCount(2, $hidden);

        $this->assertNotContains("id", $hidden);
        $this->assertNotContains("license_plate", $hidden);
        $this->assertNotContains("year_of_purchase", $hidden);
        $this->assertNotContains("colour", $hidden);
        $this->assertNotContains("fuel_type", $hidden);
        $this->assertNotContains("transmission", $hidden);
        $this->assertNotContains("manufacturer", $hidden);
        $this->assertNotContains("model", $hidden);
        $this->assertNotContains("num_seats", $hidden);
        $this->assertNotContains("num_doors", $hidden);

        $this->assertContains("created_at", $hidden);
        $this->assertContains("updated_at", $hidden);
    }

    public function testGenerateId(): void
    {
        $uuid = Vehicle::generateId();
        $this->assertTrue(is_string($uuid));
        $this->assertEquals(
            preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid),
            1
        );
    }

    public function testGetClassName(): void
    {
        $this->assertEquals($this->object::getClassName(), 'vehicle');
        $this->assertEquals($this->object::getClassName(false), 'Vehicle');
    }
}
