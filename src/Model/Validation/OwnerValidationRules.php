<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : OwnerValidationRules.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Model\Validation;

trait OwnerValidationRules
{
    /**
     * A list of rules associated with the class this Trait is paired with.
     * @var Array
     */
    protected $rules = [
        'required' => [
            'id',
            'owner_name',
        ],
        'lengthMax' => [
                ['owner_name', 255],
                ['owner_profession', 255],
                ['owner_company', 255],
            ],
    ];
}
