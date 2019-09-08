<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : Import.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

use DavegTheMighty\CarService\Controller\ImportController;

$app->post(
    '/import',
    \ImportController::class . ':importData'
)
->setName('importData');
