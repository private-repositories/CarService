<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : Owner.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */
namespace DavegTheMighty\CarService\Model;

use Valitron\Validator;

class Owner extends UuidModel
{
    use Validation\OwnerValidationRules;

    protected $fillable = [
      'id',
      'owner_name',
      'owner_profession',
      'owner_company',
    ];
    protected $hidden = ['created_at','updated_at'];

    public function vehicles()
    {
        return $this->hasMany('DavegTheMighty\CarService\Model\Vehicle');
    }
}
