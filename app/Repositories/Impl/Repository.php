<?php

namespace App\Repositories\Impl;

use App\Domain\FilterDomain;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected Model $model;
    protected array $allColumnOrder = [];
    protected array $allColumnSearch = [];
    protected array $allOrderType = ['asc', 'desc'];
    protected array $allRelation = [];
    protected array $order = ['created_at' => 'desc'];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all the resource from DB with standard format.
     *
     * @param FilterDomain $filterDomain
     * @return array
     */
    protected function __getAll(FilterDomain $filterDomain): array
    {
        $builder = $this->model;

        if ($filterDomain->relations) {
            $builder = $this->__filterWith($builder, $filterDomain->relations);
        }
        if (!is_null($filterDomain->search)) {
            $builder = $this->__filterSearch($builder, $filterDomain->search);
        }
        if ($filterDomain->conditions) {
            $builder = $this->__filterCondition($builder, $filterDomain->conditions);
        }
        if ($filterDomain->order_column && $filterDomain->order_direction) {
            $builder = $this->__filterOrder($builder, $filterDomain->order_column, $filterDomain->order_direction);
        }

        return $builder->limit($filterDomain->limit)->offset(($filterDomain->offset - 1) * $filterDomain->limit)->get()->toArray();
    }

    /**
     * Get all the resource from DB with datatable format.
     *
     * @param FilterDomain $filterDomain
     * @return array
     */
    protected function __getDatatable(FilterDomain $filterDomain): array
    {
        $builder = $this->model;
        $total = $builder->count();

        if ($filterDomain->relations) {
            $builder = $this->__filterWith($builder, $filterDomain->relations);
        }
        if (!is_null($filterDomain->search)) {
            $builder = $this->__filterSearch($builder, $filterDomain->search);
        }
        if ($filterDomain->order_column && $filterDomain->order_direction) {
            $builder = $this->__filterOrder($builder, $filterDomain->order_column, $filterDomain->order_direction);
        }
        if ($filterDomain->conditions) {
            $builder = $this->__filterCondition($builder, $filterDomain->conditions);
        }

        $totalFiltered = $builder->count();

        $data = $builder->limit($filterDomain->limit)->offset(($filterDomain->offset - 1) * $filterDomain->limit)->get()->toArray();

        return [
            'total' => $total,
            'total_filtered' => $totalFiltered,
            'data' => $data,
        ];
    }

    /**
     * Filter the resource from DB with related data.
     *
     * @param $builder
     * @param $relations
     * @return mixed
     */
    protected function __filterWith($builder, $relations): mixed
    {
        $allRelation = $this->allRelation;
        $listWith = [];

        if (is_string($relations)) {
            $relationExplode = explode(':', $relations, 2);
            $relation = $relationExplode[0] ?? null;
            $options = !empty($relationExplode[1]) ? json_decode($relationExplode[1]) : null;

            if ($relation === 'all') {
                foreach ($allRelation as $relation => $relationItem) {
                    if ($relation === 'self') continue;

                    $listWith[$relation] = function ($query) use ($relation, $relationItem, $options) {
                        if (is_string($relationItem)) {
                            $query->select($relationItem);
                            return;
                        }

                        $listSelect = [$relationItem['reference']];

                        if (!empty($options->{$relation})) {
                            $optionRelation = $options->{$relation};

                            if (!empty($optionRelation->fields)) {
                                foreach ($optionRelation->fields as $field) {
                                    if (in_array($field, $relationItem['fields'])) {
                                        $listSelect[] = $field;
                                    }
                                }
                            } else {
                                array_push($listSelect, ...$relationItem['fields']);
                            }

                            if (!empty($optionRelation->conditions->where)) {
                                foreach ($optionRelation->conditions->where as $condition) {
                                    $field = key($condition);
                                    $value = $condition->{key($condition)};

                                    if (in_array($field, $relationItem['conditions']['where'])) {
                                        $query->where($field, $value);
                                    }
                                }
                            }
                        } else {
                            array_push($listSelect, ...$relationItem['fields']);
                        }

                        $query->select($listSelect);
                    };
                }
            } else {
                if (array_key_exists($relation, $allRelation)) {
                    $listWith[$relation] = function ($query) use ($allRelation, $relation, $options) {
                        if (is_null($options)) {
                            return;
                        } elseif (is_string($options)) {
                            $query->select($options);
                            return;
                        }

                        $listSelect = [$allRelation[$relation]['reference']];

                        if (!empty($options->fields)) {
                            foreach ($options->fields as $field) {
                                if (in_array($field, $allRelation[$relation]['fields'])) {
                                    $listSelect[] = $field;
                                }
                            }
                        } else {
                            array_push($listSelect, ...$allRelation[$relation]['fields']);
                        }

                        $query->select($listSelect);

                        if (!empty($options->conditions->where)) {
                            foreach ($options->conditions->where as $condition) {
                                $field = key($condition);
                                $value = $condition->{key($condition)};

                                if (in_array($field, $allRelation[$relation]['conditions']['where'])) {
                                    $query->where($field, $value);

                                }
                            }
                        }
                    };
                }
            }
        } else if (is_array($relations)) {
            foreach ($relations as $relation) {
                $relationExplode = explode(':', $relation, 2);
                $relation = $relationExplode[0] ?? null;
                $options = !empty($relationExplode[1]) ? json_decode($relationExplode[1]) : null;

                if (array_key_exists($relation, $allRelation)) {
                    $listWith[$relation] = function ($query) use ($allRelation, $relation, $options) {
                        if (is_null($options)) {
                            return;
                        } elseif (is_string($options)) {
                            $query->select($options);
                            return;
                        }

                        $listSelect = [$allRelation[$relation]['reference']];

                        if (!empty($options->fields)) {
                            foreach ($options->fields as $field) {
                                if (in_array($field, $allRelation[$relation]['fields'])) {
                                    $listSelect[] = $field;
                                }
                            }
                        } else {
                            array_push($listSelect, ...$allRelation[$relation]['fields']);
                        }

                        $query->select($listSelect);

                        if (!empty($options->conditions->where)) {
                            foreach ($options->conditions->where as $condition) {
                                $field = key($condition);
                                $value = $condition->{key($condition)};

                                if (in_array($field, $allRelation[$relation]['conditions']['where'])) {
                                    $query->where($field, $value);
                                }
                            }
                        }
                    };
                }
            }
        }

        return $builder->with($listWith);
    }

    /**
     * Filter the resource from DB with search the data.
     *
     * @param $builder
     * @param string|null $search
     * @return mixed
     */
    protected function __filterSearch($builder, ?string $search): mixed
    {
        return $builder->where(function ($query) use ($search) {
            foreach ($this->allColumnSearch as $i => $item) {
                if ($i === 0) $query->where($item, 'like', "%$search%");
                else $query->orWhere($item, 'like', "%$search%");
            }
        });
    }

    /**
     * Filter the resource from DB with condition the data.
     *
     * @param $builder
     * @param $conditions
     * @return mixed
     */
    protected function __filterCondition($builder, $conditions): mixed
    {
        $allRelation = $this->allRelation;

        $conditions = json_decode($conditions);

        if (!is_object($conditions)) return $builder;

        foreach ($conditions as $relation => $options) {
            if (array_key_exists($relation, $allRelation)) {
                if ($relation === 'self') {
                    if (!empty($options->where)) {
                        foreach ($options->where as $condition) {
                            $field = key($condition);
                            $value = $condition->{key($condition)};

                            if (!empty($allRelation[$relation]['conditions']['where'])) {
                                if (in_array($field, $allRelation[$relation]['conditions']['where'])) {
                                    $builder->where($field, $value);
                                } else if (array_key_exists($field, $allRelation[$relation]['conditions']['where']) && in_array($value, $allRelation[$relation]['conditions']['where'][$field])) {
                                    $builder->where($field, $value);
                                }
                            }
                        }
                    }
                } else {
                    if (!empty($options->whereHas)) {
                        $builder->whereHas($relation, function ($query) use ($relation, $options, $allRelation) {
                            foreach ($options->whereHas as $condition) {
                                $field = key($condition);
                                $value = $condition->{key($condition)};

                                if (!empty($allRelation[$relation]['conditions']['whereHas']) && in_array($field, $allRelation[$relation]['conditions']['whereHas'])) {
                                    if (in_array($field, $allRelation[$relation]['conditions']['whereHas'])) {
                                        $query->where($field, $value);
                                    } else if (array_key_exists($field, $allRelation[$relation]['conditions']['whereHas']) && in_array($value, $allRelation[$relation]['conditions']['whereHas'][$field])) {
                                        $query->where($field, $value);
                                    }
                                }
                            }
                        });
                    }
                }
            }
        }

        return $builder;
    }

    /**
     * Filter the resource from DB with order the data.
     *
     * @param $builder
     * @param string|null $order_column
     * @param string|null $order_direction
     * @return mixed
     */
    protected function __filterOrder($builder, ?string $order_column, ?string $order_direction): mixed
    {
        if ($order_column && in_array($order_column, $this->allColumnOrder) && $order_direction && in_array($order_direction, $this->allOrderType)) {
            $builder = $builder->orderBy($order_column, $order_direction);
        } else {
            $builder = $builder->orderBy(key($this->order), $this->order[key($this->order)]);
        }

        return $builder;
    }
}
