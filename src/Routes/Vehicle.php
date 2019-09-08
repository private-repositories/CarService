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

$app->get(
    '/vehicles',
    \VehicleController::class . ':getAll'
)
->setName('getVehicles');

$app->get('/vehicles/{vehicle_id}', \VehicleController::class . ':get')

->setName('getVehicle');

$app->post('/vehicles', \VehicleController::class . ':post')
->setName('createVehicle');

$app->patch('/vehicles/{vehicle_id}', \VehicleController::class . ':patch')
->setName('updateVehicle');

$app->delete('/vehicles/{vehicle_id}', \VehicleController::class . ':delete')
->setName('deleteVehicle');
