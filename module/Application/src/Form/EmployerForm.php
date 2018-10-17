<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class EmployerForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('employer');

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
                'title' => 'nom employeur',
            ]
        ]);
        $this->add([
            'name' => 'adress',
            'type' => 'text',
            'options' => [
                'title' => 'Adresse',
            ]
        ]);
        $this->add([
            'name' => 'city',
            'type' => 'text',
            'options' => [
                'title' => 'ville',
            ]
        ]);
        $this->add([
            'name' => 'province',
            'type' => 'text',
            'options' => [
                'title' => 'province',
            ]
        ]);
        $this->add([
            'name' => 'postal_code',
            'type' => 'text',
            'options' => [
                'title' => 'code postal',
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
            'name' => 'id_user',
            'type' => 'number',
            'options' => [
                'title' => 'user id',
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
