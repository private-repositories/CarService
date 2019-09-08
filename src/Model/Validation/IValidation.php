<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : IValidation.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Model\Validation;

use Valitron\Validator;

interface IValidation
{
    public function validate(Validator $v) : array;

    public function getData(): array;
    public function getRules(): array;
}
