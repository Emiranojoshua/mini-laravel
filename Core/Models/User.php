<?php

namespace Core\Models;

use Core\Auth\AuthService;
use Core\Models\Resource\Model;

class User extends Model 
{
    protected array $fillable = ['email', 'password'];

    public function getUser(){
        return (new AuthService())->user();
    }
}
