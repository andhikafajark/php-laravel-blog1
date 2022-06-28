<?php

namespace App\DTO\Response\Group;

use App\DTO\DTO;

class CreateResponse extends DTO
{
    public ?string $id;
    public ?string $name;
    public ?string $created_at;
    public ?string $updated_at;
}
