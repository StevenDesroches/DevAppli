<?php

namespace Student\Form;

use Zend\Form\Form;

class StudentForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('student');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');

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
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'title' => 'courriel',
            ]
        ]);
        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'title' => 'mot de passe',
            ]
        ]);
        $this->add([
            'name' => 'file',
            'type' => 'file',
            'options' => [
                'title' => 'CV',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);

    }
}
