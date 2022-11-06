<?php

namespace App\Controllers;

use App\Models\Lesson;
use App\Controllers\Controller;

class LessonController extends Controller
{
    public function create(): void
    {
        try {
            $lesson = [
                "name" => $this->requestData->name,
                "startDate" => $this->requestData->startDate,
                "endDate" => $this->requestData->endDate,
                "capacity" => $this->requestData->capacity
            ];

            Lesson::insert($lesson);

            $this->success($lesson, 200);
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