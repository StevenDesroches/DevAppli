<?php

namespace Student\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Zend\InputFilter\FileInput;
use Zend\Validator\File\UploadFile;
use Zend\Filter\File\RenameUpload;


class Student implements InputFilterAwareInterface
{

    public $admission_number;
    public $name;
    public $email;
    public $active;
    public $user_id;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->admission_number = isset($data['admission_number']) ? $data['admission_number'] : null;
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->active = isset($data['active']) ? $data['active'] : null;
        $this->user_id = isset($data['user_id']) ? $data['user_id'] : null;

    }

    public function getArrayCopy()
    {
        return [
            'admission_number' => $this->admission_number,
            'name' => $this->name,
            'email' => $this->email,
            'active'  => $this->active,
            'user_id'  => $this->user_id,

        ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'admission_number',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'name',
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

    
