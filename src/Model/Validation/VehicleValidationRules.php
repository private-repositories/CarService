<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : VehicleValidationRules.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Model\Validation;

use DavegTheMighty\CarService\Model\Vehicle;

trait VehicleValidationRules
{
    /**
     * A list of rules associated with the class this Trait is paired with.
     * @var Array
     */
    protected $rules = [
        'required' => [
            'id',
            'license_plate',
            'manufacturer',
            'model',
        ],
        'lengthMax' => [
                ['license_plate', 10],
                ['colour', 255],
                ['fuel_type', 255],
                ['transmission', 255],
                ['manufacturer', 255],
                ['model', 255],
            ],
        'in' => [
            ['fuel_type', Vehicle::FUEL_TYPES],
            ['transmission', Vehicle::TRANSMISSION_TYPES],
        ],
        'min' => [
            ['num_seats', 1],
            ['num_doors', 1],
        ],
        'integer' => [
            'num_seats',
            'num_doors',
        ],
    ];
}
