<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class InternshipsForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('internship');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
            'options' => [
                'title' => 'le id',
            ]
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'title' => 'nom stage',
            ]
        ]);
        $this->add([
            'name' => 'date_posted',
            'type' => 'hidden', 'datetime',
            'options' => [
                'title' => 'Date du postage',
            ]
        ]);
        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'title' => 'description',
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
            'name' => 'id_employer',
            'type' => 'hidden',
            'options' => [
                'title' => 'employer id',
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
