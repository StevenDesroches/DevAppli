<?php

namespace Application\Form;

use Zend\Form\Form;

class InternshipForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('internship');

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'title' => 'nom du stage',
            ]
        ]);
        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'title' => 'description du stage',
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
            'name' => 'id_employer',
            'type' => 'hidden',
        ]);
        
    }
}
