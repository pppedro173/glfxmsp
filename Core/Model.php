<?php

namespace Core;

abstract class Model
{
    abstract protected function checkData(array $data);

    public function insertInto (array $data, string $table): void
    {
        try {
            if(! $this->checkData($data)){
                throw new \Exception('You cant insert' . print_r($data, true) . ' in ' . $table, 500);
            }
    
            array_push($data[$table], $data);
    
            file_put_contents("Db.json", json_encode($data));

        } catch(\Exception $e) {
            header('Content-Type: application/json; charset=utf-8', false, $e->getCode());

            echo json_encode(['errorMessage' => $e->getMessage()]);
            exit();
        }

    }

    public function getAll(string $table): array
    {
        $file = file_get_contents('Db.json');
        $data = json_decode($file, true);

        $all = array_values($data[$table]);

        return $all;
    }

}