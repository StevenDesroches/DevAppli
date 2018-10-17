<?php

namespace Employer\Form;

use Zend\Form\Form;

class EmployerForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('employer');

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'title' => 'nom employeur',
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
            'type' => 'text',
            'options' => [
                'title' => 'courriel',
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
        
    }
}
