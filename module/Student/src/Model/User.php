<?php
namespace Student\Model;

class User
{
    public $id;
    public $email;
    public $password;
    public $type;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->password  = !empty($data['password']) ? md5($data['password']) : null;
        $this->type;
    }
}