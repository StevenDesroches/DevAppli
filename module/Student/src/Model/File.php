<?php
namespace Student\Model;

class File{

    public $file;
    public $student_id;


    public function exchangeArray(array $data){

        $this->file= !empty($data['file']) ? $data['file'] : null;
        $this->student_id = !empty($data['student_id']) ? $data['student_id'] : null;

    }
}