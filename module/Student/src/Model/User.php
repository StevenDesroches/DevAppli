<?php
namespace Student\Model;

class Album
{
    public $id;
    public $email;
    public $password;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->password  = !empty($data['password']) ? $data['password'] : null;
    }
}