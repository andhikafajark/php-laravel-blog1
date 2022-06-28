<?php

namespace App\Domain;

use ReflectionClass;

class Domain
{
    public function __construct(array $data)
    {
        $this->refresh($data);
    }

    /**
     * Refresh object attribute with new data
     *
     * @param array $data
     * @return Domain
     */
    public function refresh(array $data): Domain
    {
        $reflection = new ReflectionClass(static::class);

        foreach ($reflection->getProperties() as $property) {
            $propertyName = $property->getName();

            if (in_array($propertyName, array_keys($data))) {
                if (!$property->getType()->isBuiltin()) {
                    $class = $property->getType()->getName();

                    $this->$propertyName = new $class((array)$data[$propertyName]);
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

        return $this;
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

    /**
     * Convert this object attribute to array for update
     *
     * @return array
     */
    public function toArrayUpdate(): array
    {
        $data = (array)clone $this;

        return array_filter($data);
    }
}
