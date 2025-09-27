<?php

namespace Core\Models;

use Core\Models\Resource\Model;

class User extends Model 
{
    protected array $fillable = ['email', 'password'];
}
