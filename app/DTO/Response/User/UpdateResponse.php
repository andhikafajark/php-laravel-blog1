<?php

namespace App\DTO\Response\User;

use App\DTO\DTO;

class UpdateResponse extends DTO
{
    public ?string $id;
    public ?string $username;
    public ?string $name;
    public ?bool $is_active;
    public ?string $created_at;
    public ?string $updated_at;
}
