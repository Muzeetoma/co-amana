<?php
namespace App\Repository;

use App\Models\User;

class UserRepository{

    public function findByEmail(string $email){
        return User::whereRaw('LOWER(email) = :email', ['email' => strtolower($email)])->first();
    }
}