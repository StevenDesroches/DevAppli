<?php
namespace Student\Model;

use Zend\InputFilter\InputFilterInterface; 
use Zend\InputFilter\InputFilterAwareInterface;  
use Zend\Filter\File\RenameUpload; 
use Zend\Validator\File\UploadFile; 
use Zend\InputFilter\FileInput; 
use Zend\InputFilter\InputFilter;

class File implements InputFilterAwareInterface{

    public $file;
    public $student_id;
    public $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter) { 
        throw new \Exception("Not used");
     } 

    public function getInputFilter() { 
        if (!$this->inputFilter) { 
           $inputFilter = new InputFilter(); 
           
           $inputFilter->add(array( 
            'name' => 'student_id', 
            'required' => true, 
            
         )); 
         $file = new FileInput('file'); 
         $file->getValidatorChain()->attach(new UploadFile()); 
         $file->getFilterChain()->attach( 
        new RenameUpload([ 
            'target'    => constant('ROOT') . '/data/uploads', 
            'randomize' => true, 'use_upload_extension' => true 
        ])); 
         $inputFilter->add($file);
         $this->inputFilter = $inputFilter; 
      } 
      return $this->inputFilter; 
    }


    public function exchangeArray(array $data){

        if(!empty($data['file'])) { 
            if(is_array($data['file'])) { 
               $this->file = str_replace("/public", "", $data['file']['tmp_name']); 
            } else { 
               $this->file = $data['file']; 
            } 
         } else { 
            $data['file'] = null; 
         }
        $this->student_id = !empty($data['student_id']) ? $data['student_id'] : null;

    }
}