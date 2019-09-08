<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : NewModelTrait.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Controller\Traits;

use Psr\Http\Message\ServerRequestInterface;

trait NewModelTrait
{

    protected function newModel(ServerRequestInterface $request): void
    {
        $resource = $this->getSetModel();
        $this->class_name = $resource->getClassName(false);

        $newID = $resource::generateId();
        $this->logger->info("Creating New {$this->class_name}", [$newID]);

        $this->model = new $resource(['id'=> $newID]);
    }
}
