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

    public function create(): void
    {
        try {
            $this->lessonService->validateData($this->requestData);
            
            $lessons = (object)[
                'name' => $this->requestData->name,
                'capacity' => $this->requestData->capacity,
                'startDate' => $this->requestData->startDate,
                'endDate' => $this->requestData->endDate
            ];

            $this->lessonService->datesBooked($lessons->startDate, $lessons->endDate);

            $lessonsInserted = $this->lessonService->insertLessons($lessons);

            $this->success($lessonsInserted, 200);
        } catch (\Exception $e) {
            $this->failure($e->getMessage(), $e->getCode());
        }
    }

    public function list(): void
    {
        try {
            $lessons = $this->lessonService->getLessons();

            if(! $lessons){
                throw new \Exception('Lessons not found.', 404);
            }

            $this->success($lessons, 200);
        } catch (\Exception $e) {
            $this->failure($e->getMessage(), $e->getCode());
        }
    }
}