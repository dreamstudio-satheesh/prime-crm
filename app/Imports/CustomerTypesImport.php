<?php

namespace App\Imports;

use App\Models\CustomerType;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomerTypesImport implements ToModel
{
    public function model(array $row)
    {
        return new CustomerType([
            'name' => $row[0],
            'description' => $row[1],
        ]);
    }
}