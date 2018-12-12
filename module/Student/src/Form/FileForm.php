<?php
namespace Student\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\FileInput;

class FileForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct();
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
        
        // Set binary content encoding
        $this->setAttribute('enctype', 'multipart/form-data');  
        
        $this->addElements();
        $this->addInputFilter();          
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() 
    {
        // Add "file" field
        $this->add([
            'type'  => 'file',
            'name' => 'file',
            'attributes' => [               
                'id' => 'file'
            ],
            'options' => [
                'label' => 'Upload CV',
            ],
        ]);

        $this->add([
            'type'  => 'hidden',
            'name' => 'student_id',
            'options' => [
                'label' => 'id de student',
            ],
        ]);
        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Upload',
                'id' => 'submitbutton',
            ],
        ]);       
        
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() 
    {
        $inputFilter = $this->getInputFilter();        
        
        // Add validation rules for the "file" field	 
        $inputFilter->add([
                'type'     => FileInput::class,
                'name'     => 'file',
                'required' => true,                           
                'validators' => [
                    ['name'    => 'FileUploadFile'],
                    [
                        'name'    => 'FileMimeType',                        
                        'options' => [                            
                            'mimeType'  => ['application/pdf']
                        ]
                    ],
                                  
                ],
                'filters'  => [                    
                    [
                        'name' => 'FileRenameUpload',
                        'options' => [  
                            'target'=>'/data/upload',
                            'useUploadName'=>true,
                            'useUploadExtension'=>true,
                            'overwrite'=>true,
                            'randomize'=>false
                        ]
                    ]
                ],     
            ]);                        
    }
}