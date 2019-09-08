<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : VehicleController.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Controller;

//phpcs:ignore PSR2.Namespaces.UseDeclaration.MultipleDeclarations
use DavegTheMighty\CarService\Model\{
    Owner,
    Vehicle
};

use Interop\Container\ContainerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class VehicleController
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    protected $logger;
    protected $validator;

    /**
     * GenericModelController constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->logger;
        $this->validator = $container->validator;
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getAll(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            //Use Supplied params as an exact match
            $params = $request->getQueryParams();
            //Allow Sort by field name
            $sortBy = 'id';
            if (isset($params['sort'])) {
                $sortBy =  $params['sort'];
                unset($params['sort']);
            }

            $collection = Vehicle::where($params)->orderBy($sortBy, 'ASC')->get();

            return $response
                ->withStatus(200)
                ->write(json_encode($collection, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\ControllerException $e) {
            return $response->withStatus(500);
        } catch (\RuntimeException $e) {
            $this->logger->error("Unhandled Exception in get all route", [$e]);
            return $response->withStatus(500);
        }
    }


    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getByOwnerId(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $owner = Owner::findOrFail($args['owner_id']);
            return $response
                ->withStatus(200)
                ->write(json_encode($owner->vehicles, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\ControllerException $e) {
            return $response->withStatus(500);
        } catch (\RuntimeException $e) {
            $this->logger->error("Unhandled Exception in get all route", [$e]);
            return $response->withStatus(500);
        }
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getByOwnerName(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $owner = Owner::where(['owner_name' => $args['owner_name']])->firstOrFail();
            return $response
                ->withStatus(200)
                ->write(json_encode($owner->vehicles, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\ControllerException $e) {
            return $response->withStatus(500);
        } catch (\RuntimeException $e) {
            $this->logger->error("Unhandled Exception in get all route", [$e]);
            return $response->withStatus(500);
        }
    }
}
