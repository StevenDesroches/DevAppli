<?php
namespace Application\Model;
use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

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

    public function getArrayCopy(){
        return[
            'id' => $this->id,
            'name' => $this->name,
            'date_posted' => $this->date_posted,
            'description' => $this->description,
            'active' => $this->active,
            'employer' => $this->employer,
            'id_employer' => $this->id_employer

        ];
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'Nom',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'Description',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);


        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}