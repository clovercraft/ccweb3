<?php

namespace App\Models\SMP;

use App\Models\Settlement as ModelsSettlement;

class Settlement
{

    private $model;

    public function __construct(ModelsSettlement $model)
    {
        $this->model = $model;
    }

    public function format(): array
    {
        $formatted = [
            'id'    => $this->model->id,
            'slug'  => $this->model->slug,
            'name'  => $this->model->name,
            'member_count'  => count($this->model->members)
        ];
        return $formatted;
    }
}
