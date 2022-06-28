<?php

namespace App\DTO\Request;

use App\DTO\DTO;

class IndexRequest extends DTO
{
    public bool $datatable = false;
    public bool $mapping = false;
    public ?int $limit = 10;
    public ?int $offset = 1;
    public ?string $order_column = null;
    public ?string $order_direction = null;
    public ?string $search = null;
    public ?string $relations = null;
    public ?string $conditions = null;

    /**
     * Convert this object attribute to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = clone $this;

        if (!isset($data->search) || is_null($this->search)) $data->search = '';

        return (array)$data;
    }
}
