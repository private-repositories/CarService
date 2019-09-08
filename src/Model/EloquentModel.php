<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : EloquentModel.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

use DavegTheMighty\CarService\Model\Validation\IValidation;
use DavegTheMighty\CarService\Model\Validation\ModelValidation;

use Psr\Http\Message\ServerRequestInterface;

abstract class EloquentModel extends Eloquent implements IValidation
{
    use ModelValidation;

    protected $fillable = ['id'];

    //Define which relationships are eager loaded
    //Note, on create, these are not included without a 'fresh', or similar following save()
    protected $with = [];

    //Define which fields and relationships to return for the serialised model
    //
    //Note: With fields need to be present for visible relationships
    //If not specified, this is all non hidden fields.
    //If any fields are specified, this is all that is returned.
    protected $visible = [];

    //Define which fields and relationships not to return for the serialised model
    //Only used if no visible fields are defined.
    protected $hidden = ['created_at', 'updated_at'];

    abstract public static function generateId();

    public static function getClassName(bool $lower_case = true): string
    {
        $class_name = basename(str_replace('\\', '/', static::class));

        if ($lower_case) {
             $class_name = strtolower($class_name);
        }

        return $class_name;
    }

    public static function getRouteId(): string
    {
        $class_name = static::getClassName();
        return $class_name.'_id';
    }

    /**
     * Get the Id of the object from the route body or args
     * @param  RouteInterface $route [description]
     * @return string                [description]
     */
    public static function findIdFromRequest(ServerRequestInterface $request): ? string
    {
        $route_id = static::getRouteId();
        //The ID will either be in the Request Params, or the Route Args
        //I need to check this isn't going to cause ambiguity
        $self_id = $request->getParam($route_id);
        if ($self_id === null) {
            $route = $request->getAttribute('route');
            $self_id = $route->getArgument($route_id);
        }
        return $self_id;
    }

    /**
     * Get the Id of the object from the route body or args
     * @param  RouteInterface $route [description]
     * @return string                [description]
     */
    //FIXME: Can be generic
    //FIXME: Can  be extended for special cases
    public static function findFromRequest(ServerRequestInterface $request): ?EloquentModel
    {
        return self::findOrFail(self::findIdFromRequest($request));
    }

    /**
     * Determine whether the resource can be deleted
     * @return array Return an array of errors if this model should not be deleted.
     */
    public function validateDelete() : array
    {
        $errors = [];
        return $errors;
    }

    public function getLocation(): string
    {
        return $this::getClassName()."/".$this->id;
    }
}
