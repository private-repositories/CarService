<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : Vehicle.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */
namespace DavegTheMighty\CarService\Model;

use Valitron\Validator;

class Vehicle extends UuidModel
{
    use Validation\VehicleValidationRules;

    protected $fillable = [
      'id',
      'license_plate',
      'year_of_purchase',
      'colour',
      'fuel_type',
      'transmission',
      'manufacturer',
      'model',
      'num_seats',
      'num_doors',
    ];
    protected $hidden = ['created_at','updated_at'];

    protected $with = [
        'owner'
    ];

    const FUEL_TYPE_PETROL = 'petrol';
    const FUEL_TYPE_DIESEL = 'diesel';

    const TRANSMISSION_TYPE_MANUAL = 'manual';
    const TRANSMISSION_TYPE_AUTOMATIC = 'automatic';

    const FUEL_TYPES = [
        self::FUEL_TYPE_PETROL,
        self::FUEL_TYPE_DIESEL
    ];

    const TRANSMISSION_TYPES = [
        self::TRANSMISSION_TYPE_AUTOMATIC,
        self::TRANSMISSION_TYPE_MANUAL
    ];

    public function owner()
    {
        return $this->belongsTo('DavegTheMighty\CarService\Model\Owner');
    }
}
