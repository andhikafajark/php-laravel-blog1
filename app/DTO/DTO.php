<?php

namespace App\DTO;

use Illuminate\Http\UploadedFile;
use ReflectionClass;

class DTO
{
    public function __construct(array $data)
    {
        $reflection = new ReflectionClass(static::class);

        foreach ($reflection->getProperties() as $property) {
            $propertyName = $property->getName();

            if (in_array($propertyName, array_keys($data))) {
                if (!$property->getType()->isBuiltin()) {
                    $class = $property->getType()->getName();

                    if ($class === UploadedFile::class) {
                        $this->$propertyName = $data[$propertyName];
                    } else {
                        $this->$propertyName = new $class((array)$data[$propertyName]);
                    }
                } else {
                    $typeData = $property->getType()->getName();

                    if ($typeData === 'object') {
                        $this->$propertyName = (object)json_decode(json_encode($data[$propertyName]));
                    } else if ($typeData === 'array') {
                        $this->$propertyName = (array)$data[$propertyName];
                    } else {
                        $this->$propertyName = $data[$propertyName];
                    }
                }
            }
        }
    }

    /**
     * Convert this object attribute to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return (array)clone $this;
    }
}
