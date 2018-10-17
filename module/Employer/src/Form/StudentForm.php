<?php

namespace Application\Form;

use Zend\Form\Form;

class StudentForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('student');

        $this->add([
            'name' => 'admission_number',
            'type' => 'number',
            'options' => [
                'title' => 'numero admission',
            ]
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'title' => 'nom etudiant',
            ]
        ]);
        $this->add([
            'name' => 'active',
            'type' => 'checkbox',
            'options' => [
                'title' => 'actif',
            ]
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
        $this->add([
            'name' => 'user_id',
            'type' => 'hidden',
        ]);
        
    }
}
