<?php

namespace App\Services;

use DateTime;

class LessonService
{

    public  function validateData(?object $request): void
    {
        if(is_null($request)){
            throw new \Exception('Invalid request', 400);
        }
        
        $this->validateLessonCreateRequestStruct($request);
        $this->validateLessonDataTypes($request);
        $this->validateLessonDataConstraints($request);
    }

    private function validateLessonCreateRequestStruct(object $request): void
    {
        if(! property_exists($request, 'name')){
            throw new \Exception('Its mandatory to provide a class name', 400);
        }

        if(! property_exists($request, 'startDate')){
            throw new \Exception('Its mandatory to provide a class startDate', 400);
        }

        if(! property_exists($request, 'endDate')){
            throw new \Exception('Its mandatory to provide a class endDate', 400);
        }

        if(! property_exists($request, 'capacity')){
            throw new \Exception('Its mandatory to provide a class name', 400);
        }

    }

    private function validateLessonDataTypes(object $lessonData): void 
    {
        if(! is_string($lessonData->name)){
            throw new \Exception('Class name has to be a string', 400);
        }

        if(! is_int($lessonData->capacity)){
            throw new \Exception('Class capacity has to be a number', 400);
        }

        
    }

    private function validateLessonDataConstraints(object $lessonData): void
    {
        $dtStartSate = new DateTime($lessonData->startDate);
        $dtEndDate = new DateTime($lessonData->endDate);
        $today = new DateTime();

        if($dtStartSate < $today){
            throw new \Exception('starting date is prior to today', 400);
        }

        if($dtStartSate > $dtEndDate){
            throw new \Exception('end date is prior to starting date', 400);
        }

        if($lessonData->capacity > 10){
            throw new \Exception('The max capacity is 10', 400);
        }

        if($lessonData->capacity < 0){
            throw new \Exception('Invalid capacity', 400);
        }

        if(strlen($lessonData->name) > 32){
            throw new \Exception('Class name too long', 400);
        }
    }
}