<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : UuidModel.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Model;

use Ramsey\Uuid\Uuid;

abstract class UuidModel extends EloquentModel
{

    public $incrementing = false;
    /**
     * Intended for Resource Models, which will ordinarily have timestamps
     */
    public $timestamps = true;

    public static function generateId()
    {
        //Generate UUID
        return Uuid::uuid4()->toString();
    }
}
