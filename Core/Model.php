<?php

namespace Core;

abstract class Model
{
    protected static $table;

    public static function insert (array $data): void
    {
        $allData = self::get();

        array_push($allData, $data);
        file_put_contents("../Db.json", json_encode([static::$table => $allData]));
    }

    public  static function get(): array
    {
        $file = file_get_contents('../Db.json');
        $data = json_decode($file, true);

        $all = array_values($data[static::$table]);

        return $all;
    }

}