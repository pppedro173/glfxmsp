<?php

namespace App\Controllers;

use App\Models\Lesson as Lesson;
use Core\Controller as BaseController;

class LessonController extends BaseController
{
    public function create(): array
    {
        $lesson = [
            "name" => $this->requestData->name,
            "startDate" => $this->requestData->startDate,
            "endDate" => $this->requestData->endDate,
            "capacity" => $this->requestData->capacity
        ];

        Lesson::insert($lesson);

        return $lesson;
    }

    public function list(): array
    {
        $lessons = Lesson::get();
        return $lessons;
    }
}