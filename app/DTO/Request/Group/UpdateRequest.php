<?php

namespace App\DTO\Request\Group;

use App\DTO\DTO;

class UpdateRequest extends DTO
{
    public string $id;
    public string $name;
}
