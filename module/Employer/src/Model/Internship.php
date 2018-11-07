<?php
namespace Employer\Model;

class Internship
{
    public $id;
    public $name;
    public $date_posted;
    public $description;
    public $active;
    public $employer;
    public $id_employer;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->date_posted = !empty($data['date_posted']) ? $data['date_posted'] : null;
        $this->description = !empty($data['description']) ? $data['description'] : null;
        $this->active = !empty($data['active']) ? $data['active'] : null;
        $this->id_employer = !empty($data['id_employer']) ? $data['id_employer'] : null;
    }
}