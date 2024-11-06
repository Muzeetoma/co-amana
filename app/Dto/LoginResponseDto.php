<?php
namespace App\Dto;

class LoginResponseDto
{
    public $token;
    public $email;
    public $name;

    public function __construct($name, $email, $token)
    {
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }
}
