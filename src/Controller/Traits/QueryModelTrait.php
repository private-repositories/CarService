<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : QueryModelTrait.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Controller\Traits;

use DavegTheMighty\CarService\Exceptions\ControllerException;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Psr\Http\Message\ServerRequestInterface;

trait QueryModelTrait
{
    protected function queryModel(ServerRequestInterface $request): Collection
    {
        try {
            $this->getModel($request);
            $this->class_name = $this->model->getClassName(false);
            //Find Object Trait
            $params = $request->getQueryParams();

            $collection = $this->model::where($params)->get();

            if (!$collection) {
                $this->logger->notice(
                    "Get All {$class_name} returned no objects for supplied params ".print_r($params, true)
                );
            }
            return $collection;
        } catch (\RuntimeException $runtimeException) {
            $this->logger->error(
                "Request failed due to Runtime exception.",
                [$runtimeException]
            );
            throw new ControllerException($runtimeException);
        }
    }
}
