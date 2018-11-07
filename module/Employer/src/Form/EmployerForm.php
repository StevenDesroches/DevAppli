<?php

namespace Employer\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Validator\Uuid;

class EmployerForm extends Form
{

    public static function uuid()
    {
        $random = function_exists('random_int') ? 'random_int' : 'mt_rand';
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            $random(0, 65535),
            $random(0, 65535),
            // 16 bits for "time_mid"
            $random(0, 65535),
            // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
            $random(0, 4095) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            $random(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            $random(0, 65535),
            $random(0, 65535),
            $random(0, 65535)
        );
    }

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
            'name' => 'contact_email',
            'type' => 'text',
            'options' => [
                'title' => 'courriel de contact',
            ]
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'title' => 'courriel de compte',
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
            'name' => 'active',
            'type' => 'checkbox',
            'options' => [
                'title' => 'actif',
            ]

        ]);
        $this->add([
            'name' => 'uuid',
            'type' => 'hidden',
            'attributes' => [
                'value' => self::uuid(),
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
