<?php
namespace Employer\Model;

class Students_Internships
{
    public $student_id;
    public $internship_id;

    public function exchangeArray(array $data)
    {
        $this->student_id = !empty($data['student_id']) ? $data['student_id'] : null;
        $this->internship_id = !empty($data['internship_id']) ? $data['internship_id'] : null;
    }
}