<?php

namespace Employer\Model;

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
    public $active;
    public $file;
    public $user_id;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->admission_number = isset($data['admission_number']) ? $data['admission_number'] : null;
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->active = isset($data['active']) ? $data['active'] : null;
        $this->user_id = isset($data['user_id']) ? $data['user_id'] : null;
        $this->email = isset($data['email']) ?  $data['email'] : null;

        if(!empty($data['file'])) { 
            if(is_array($data['file'])) { 
               $this->file = str_replace("./public", "", 
                  $data['imagepath']['tmp_name']); 
            } else { 
               $this->imagepath = $data['file']; 
            } 
         } else { 
            $data['file'] = null; 
         } 
    }

    public function getArrayCopy()
    {
        return [
            'admission_number' => $this->admission_number,
            'name' => $this->name,
            'active'  => $this->active,
            'file' => $this->file,
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
        $file = new FileInput('file'); 
        $file->getValidatorChain()->attach(new UploadFile()); 
        $file->getFilterChain()->attach( 
           new RenameUpload([ 
              'target'    => './public/uploads', 
              'use_upload_extension' => true 
           ])); 
           $inputFilter->add($file);  

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
    }

    
