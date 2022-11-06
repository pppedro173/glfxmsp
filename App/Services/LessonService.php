<?php

namespace App\Services;

use App\Models\Lesson;
use Core\Validator;
use DateInterval;
use DatePeriod;
use DateTime;

class LessonService
{
    public function getLessons(): array
    {
        return Lesson::get();
    }

    public function datesBooked(string $startDate, string $enDate): void
    {
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($enDate)
       );

       $lessons = $this->getLessons();
       
       $dates = array_column($lessons, 'date');

       foreach($period as $key => $value){
        if(in_array($value->format('Y-m-d'), $dates)){
            throw new \Exception('You cant select a date range with allready booked classes in it.', 400);
        }
       }
    }

    public function insertLessons(object $lessons): array
    {
        $startDate = new DateTime(date('Y-m-d', strtotime($lessons->startDate)));
        $endDate = new DateTime(date('Y-m-d', strtotime($lessons->endDate)));

        $lessonsArr = [];

        $lesson = [
            'name' => $lessons->name,
            'capacity' => $lessons->capacity,
            'date' => $startDate->format('Y-m-d')
        ];

        $endDate->modify('+1 day');
            
        while($startDate->diff($endDate)->days != 0){
            Lesson::insert($lesson);
            array_push($lessonsArr, $lesson);
            $startDate->modify('+1 day');
            $lesson['date'] = $startDate->format('Y-m-d');
        }

        return $lessonsArr;
    }

    public function lessonExists(string $date):bool
    {
        $lessons = $this->getLessons();
        
        if(!$lessons){
            return false;
        }
       
        $dates = array_column($lessons, 'date');

        if(in_array($date, $dates)){
            return true;
        }

        return false;
    }

    public function validateCreateRequest(object $request): void
    {
        $validation = Validator::requestStruct($request, ['name', 'startDate', 'endDate', 'capacity']);

        if(! $validation->success){
            throw new \Exception($validation->error, 400);
        }
    }

    public function validateLessonsObj(object $lessons): void 
    {
        $validation = Validator::dataTypes($lessons, [
            'name' => "string", 
            'capacity' => 'integer', 
            'startDate' => "string", 
            'endDate' => "string"
        ]);

        if(! $validation->success){
            throw new \Exception($validation->error, 400);
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

        if($lessonData->capacity < 0){
            throw new \Exception('Invalid capacity', 400);
        }
    }
}