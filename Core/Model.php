<?php

namespace Core;

abstract class Model
{
    protected static $table;

    public static function insert (array $data): void
    {
        $file = file_get_contents('/Users/palexaso/Sites/glfxmsp/Db.json');
        $allData = json_decode($file, true);

        $modelData = array_values($allData[static::$table]);

        array_push($modelData, $data);
        
        $allData[static::$table] = $modelData;

        file_put_contents('/Users/palexaso/Sites/glfxmsp/Db.json', json_encode($allData));
    }

    public  static function get(): array
    {
        $file = file_get_contents('/Users/palexaso/Sites/glfxmsp/Db.json');
        $data = json_decode($file, true);

        $all = array_values($data[static::$table]);

        return $all;
    }

}