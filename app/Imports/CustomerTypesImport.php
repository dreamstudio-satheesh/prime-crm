<?php

namespace App\Imports;

use App\Models\CustomerType;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomerTypesImport implements ToModel
{
    public function model(array $row)
    {
        return CustomerType::updateOrCreate(
            ['id' => $row['id']], 
            [
                'name' => $row['name'],
                'description' => $row['description'],
            ]
        );
    }
}
