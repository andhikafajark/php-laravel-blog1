<?php

namespace App\DTO\Request\User;

use App\DTO\DTO;

class UpdateRequest extends DTO
{
    public string $id;
    public ?string $username;
    public ?string $password;
    public ?string $name;
    public ?bool $is_active;
}
