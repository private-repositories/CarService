<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : Owner.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

use DavegTheMighty\CarService\Controller\OwnerController;

$app->get(
    '/owners',
    \OwnerController::class . ':getAll'
)
->setName('getOwners');

$app->get('/owners/{owner_id}', \OwnerController::class . ':get')

->setName('getOwner');

$app->post('/owners', \OwnerController::class . ':post')
->setName('createOwner');

$app->patch('/owners/{owner_id}', \OwnerController::class . ':patch')
->setName('updateOwner');

$app->delete('/owners/{owner_id}', \OwnerController::class . ':delete')
->setName('deleteOwner');
