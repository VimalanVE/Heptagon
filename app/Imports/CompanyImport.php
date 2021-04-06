<?php

namespace App\Imports;

use App\Company;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CompanyImport implements ToModel, WithStartRow
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
        return new Company([
            'name' => $row[0],
            'email' => $row[1],
            'logo' => $row[2],
            'website' => $row[3],
            'is_active' => $row[4],
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
