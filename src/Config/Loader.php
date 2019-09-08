<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : Loader.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

//phpcs:ignore PSR2.Namespaces.UseDeclaration.MultipleDeclarations
use DavegTheMighty\CarService\Controller\{
  ImportController,
  VehicleController
};
use Interop\Container\ContainerInterface;

$container = $app->getContainer();

$container['ImportController'] = function (ContainerInterface $c) {
    return new ImportController($c);
};

$container['VehicleController'] = function (ContainerInterface $c) {
    return new VehicleController($c);
};
