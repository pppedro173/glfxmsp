<?php

namespace Core;

class Validator
{
    protected static $validator = [
        'success' => true,
        'error' => null
    ];

    public static function requestStruct(?object $request, array $properties): object
    {
        $validation = (object) self::$validator;

        if(is_null($request)){
            $validation->success = false;
            $validation->error = 'Empty request';
            return $validation;
        }

        foreach($properties as $property){
            if(! property_exists($request, $property)){
                $validation->success = false;
                $validation->error = 'Request is missing property ' . $property;
                break;
            }
        }

        return $validation;
    }

    public static function dataTypes(?object $obj, array $propTypes): object
    {
        $validation = (object) self::$validator;

        foreach($propTypes as $key => $value){
            if($value != gettype($obj->$key)){
                $validation->success = false;
                $validation->error = 'Property ' . $key . ' has to be of type ' . $value . 'but has type ' . gettype($obj->$key);
                return $validation;
            }
        }

        return $validation;
    }
}