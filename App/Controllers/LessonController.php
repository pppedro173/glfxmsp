<?php

namespace App\Controllers;

use App\Models\Lesson;
use DateTime;

class LessonController extends BaseController
{
    public function create(): void
    {
        try {
            $startDate = new DateTime(date('Y-m-d', strtotime($this->requestData->startDate)));
            $endDate = new DateTime(date('Y-m-d', strtotime($this->requestData->endDate)));
            $lessonsArr = [];
            $lesson = [
                'name' => $this->requestData->name,
                'capacity' => $this->requestData->capacity,
                'date' => $startDate->format('Y-m-d')
            ];

            while($startDate->diff($endDate)->days >= 0){
                Lesson::insert($lesson);
                array_push($lessonsArr, $lesson);
                $startDate->modify('+1 day');
                $lesson['date'] = $startDate->format('Y-m-d');
            }

            $this->success($lessonsArr, 200);
        } catch (\Exception $e) {
            $this->failure($e->getMessage(), $e->getCode());
        }
    }

    public function list(): void
    {
        try {
            $lessons = Lesson::get();

            if(! $lessons){
                throw new \Exception('Lessons not found.', 404);
            }

            $this->success($lessons, 200);
        } catch (\Exception $e) {
            $this->failure($e->getMessage(), $e->getCode());
        }
    }
}