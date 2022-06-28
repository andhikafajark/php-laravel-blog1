<?php

namespace App\DTO\Request\User;

use App\DTO\DTO;

class CreateRequest extends DTO
{
    public string $username;
    public string $password;
    public string $name;
    public bool $is_active;
}
