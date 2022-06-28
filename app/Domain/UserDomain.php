<?php

namespace App\Domain;

use Illuminate\Support\Facades\Hash;
use ReflectionClass;

class UserDomain extends Domain
{
    public ?string $id = null;
    public ?string $username = null;
    public ?string $password = null;
    public ?string $name = null;
    public ?bool $is_active = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    /**
     * Convert this object attribute to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = clone $this;

        if (!isset($data->id)) unset($data->id);
        if (isset($data->password)) {
            $data->password = Hash::make($data->password);
        } else {
            unset($data->password);
        }

        return (array)$data;
    }
}
