<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : Vehicle.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

use DavegTheMighty\CarService\Controller\VehicleController;

//- The ability to filter all available vehicles by owner
$app->get(
    '/owners/{owner_id:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}}/vehicles',
    \VehicleController::class . ':getByOwnerId'
)
->setName('getByOwnerId');

$app->get('/owners/{owner_name}/vehicles', \VehicleController::class . ':getByOwnerName')
->setName('getByOwnerName');

//    - The ability to filter sort available vehicles by year of purchase
//    - The ability to filter search available vehicles by registration plate
$app->get('/vehicles', \VehicleController::class . ':getAll')
->setName('getAll');
