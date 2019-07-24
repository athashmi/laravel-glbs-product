<?php

namespace App\Imports;

use App\CourierRate;
use Maatwebsite\Excel\Concerns\ToModel;

class CourierRateImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // if($row[0] == 'weight' && $row[1] == 'amount')
        // {
        //     return new CourierRate([
        //     //
        //     ]);
        // }
        
    }

    public function rules(): array
    {
        return [
            'weight' => 'required',
            'amount' => 'required',
        ];
    }
}
