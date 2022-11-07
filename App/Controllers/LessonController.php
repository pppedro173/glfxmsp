<?php

namespace App\Controllers;

use App\Services\LessonService;

class LessonController extends BaseController
{
    /**
     * @var LessonService
    */
    protected $lessonService;

    public function __construct(?object $requestData)
    {
        parent::__construct($requestData);
        $this->lessonService = new LessonService;
    }

    public function create(): string
    {
        try {
            $this->lessonService->validateCreateRequest($this->requestData);
            
            $lessons = (object)[
                'name' => $this->requestData->name,
                'capacity' => $this->requestData->capacity,
                'startDate' => $this->requestData->startDate,
                'endDate' => $this->requestData->endDate
            ];

            $this->lessonService->validateLessonsObj($lessons);

            $this->lessonService->datesBooked($lessons->startDate, $lessons->endDate);

            $lessonsInserted = $this->lessonService->insertLessons($lessons);

            return $this->success($lessonsInserted, 200);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), $e->getCode());
        }
    }

    public function list(): string
    {
        try {
            $lessons = $this->lessonService->getLessons();

            if(! $lessons){
                throw new \Exception('Lessons not found.', 404);
            }

            return $this->success($lessons, 200);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), $e->getCode());
        }
    }
}