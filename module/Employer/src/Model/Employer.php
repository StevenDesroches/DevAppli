<?php
namespace Employer\Model;

class Employer
{
    public $id;
    public $name;
    public $contact_email;
    public $adress;
    public $city;
    public $province;
    public $postal_code;
    public $active;
    public $date_created;
    public $id_user;
    public $uuid;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->contact_email = !empty($data['contact_email']) ? $data['contact_email'] : null;
        $this->adress = !empty($data['adress']) ? $data['adress'] : null;
        $this->city = !empty($data['city']) ? $data['city'] : null;
        $this->province = !empty($data['province']) ? $data['province'] : null;
        $this->postal_code = !empty($data['postal_code']) ? $data['postal_code'] : null;
        $this->active = !empty($data['active']) ? $data['active'] : null;
        $this->date_created = !empty($data['date_created']) ? $data['date_created'] : null;
        $this->id_user = !empty($data['id_user']) ? $data['id_user'] : null;
        $this->uuid = !empty($data['uuid']) ? $data['uuid'] : null;
    }

    public function getArrayCopy(){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'contact_email' => $this->contact_email,
            'adress' => $this->adress,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'active' => $this->active,
            'date_created' => $this->date_created,
            'id_user' => $this->id_user,
            'uuid' => $this->uuid,
        ];
    }
}