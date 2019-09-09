<?php declare(strict_types=1);

namespace DavegTheMighty\CarService\Test\Unit\Model\Validation;

use PHPUnit\Framework\TestCase;
use DavegTheMighty\CarService\Model\Vehicle;
use Valitron\Validator;

final class VehicleValidationTest extends TestCase
{
    private $object;
    protected $validator;

    protected function setUp() : void
    {
        $this->validator = new Validator();
        $this->object = new Vehicle();
    }

    public function testAllErrorsForNewSensor(): void
    {
        $errors = $this->object->validate($this->validator);

        $this->assertCount(4, $errors);

        $this->assertContains('Id is required', $errors['id']);

        $this->assertContains('License Plate is required', $errors['license_plate']);
        $this->assertContains('License Plate must not exceed 10 characters', $errors['license_plate']);

        $this->assertContains('Manufacturer is required', $errors['manufacturer']);
        $this->assertContains('Manufacturer must not exceed 255 characters', $errors['manufacturer']);

        $this->assertContains('Model is required', $errors['model']);
        $this->assertContains('Model must not exceed 255 characters', $errors['model']);
    }

    public function testId(): void
    {
        $name = 'id';
        $label = 'Id';

        $errors = ($this->object->fill([$name => ""]))->validate($this->validator);
        $this->assertEquals($errors[$name][0], "{$label} is required");

        $errors = ($this->object->fill([$name => "123"]))->validate($this->validator);
        if (\array_key_exists($name, $errors)) {
            $this->assertNotContains("{$label} is required", $errors[$name]);
        } else {
            $this->assertArrayNotHasKey($name, $errors);
        }
    }

    public function testLicensePlate(): void
    {

        $name = 'license_plate';
        $label = 'License Plate';
        $max = 10;

        $errors = ($this->object->fill([$name => ""]))->validate($this->validator);
        $this->assertEquals($errors[$name][0], "{$label} is required");

        $errors = ($this->object->fill([$name => "123"]))->validate($this->validator);
        if (\array_key_exists($name, $errors)) {
            $this->assertNotContains("{$label} is required", $errors[$name]);
        } else {
            $this->assertArrayNotHasKey($name, $errors);
        }

        $value = str_pad("A", ($max + 1), "A");
        $errors = $this->object->fill([$name =>  $value])->validate($this->validator);
        $this->assertContains("{$label} must not exceed {$max} characters", $errors[$name]);
    }

    public function testManufacturer(): void
    {

        $name = 'manufacturer';
        $label = 'Manufacturer';
        $max = 255;

        $errors = ($this->object->fill([$name => ""]))->validate($this->validator);
        $this->assertEquals($errors[$name][0], "{$label} is required");

        $errors = ($this->object->fill([$name => "123"]))->validate($this->validator);
        if (\array_key_exists($name, $errors)) {
            $this->assertNotContains("{$label} is required", $errors[$name]);
        } else {
            $this->assertArrayNotHasKey($name, $errors);
        }

        $value = str_pad("A", ($max + 1), "A");
        $errors = $this->object->fill([$name =>  $value])->validate($this->validator);
        $this->assertContains("{$label} must not exceed {$max} characters", $errors[$name]);
    }

    public function testModel(): void
    {

        $name = 'model';
        $label = 'Model';
        $max = 255;

        $errors = ($this->object->fill([$name => ""]))->validate($this->validator);
        $this->assertEquals($errors[$name][0], "{$label} is required");

        $errors = ($this->object->fill([$name => "123"]))->validate($this->validator);
        if (\array_key_exists($name, $errors)) {
            $this->assertNotContains("{$label} is required", $errors[$name]);
        } else {
            $this->assertArrayNotHasKey($name, $errors);
        }

        $value = str_pad("A", ($max + 1), "A");
        $errors = $this->object->fill([$name =>  $value])->validate($this->validator);
        $this->assertContains("{$label} must not exceed {$max} characters", $errors[$name]);
    }
}
