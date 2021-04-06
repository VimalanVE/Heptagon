<?php

namespace App\Imports;

use App\Employee;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EmployeeImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        /*
         * Used php artisan make:import to get Import module for a Model
         * We need to specify key as column name and value as row in uploaded Excel
        */
        return new Employee([
            'firstName' => $row[0],
            'lastName' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'company' => $row[4],
            'is_active' => $row[5],
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        /*
         * First row of the excel is header and no need to save it in DB
         * Implemented WithStartRow interface to skip the first row of the excel
        */
        return 2;
    }
}
