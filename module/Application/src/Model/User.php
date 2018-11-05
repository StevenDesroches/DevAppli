<?php
namespace Application\Model;

class User
{
    public $id;
    public $email;
    public $password;
    public $userType;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->password  = !empty($data['password']) ? $data['password'] : null;
        $this->userType  = !empty($data['user_type']) ? $data['user_type'] : null;

    }
}