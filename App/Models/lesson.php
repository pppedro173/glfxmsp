<?php

namespace App\Models;

use Core\Model as Model;

class Lesson extends Model
{
    protected $table = "Lessons";

    protected function checkdata(array $data): bool
    {
        return false;
    }
}