<?php

namespace App\DTO\Request;

use App\DTO\DTO;

class ShowRequest extends DTO
{
    public string $id;
    public ?string $relations = null;
}
