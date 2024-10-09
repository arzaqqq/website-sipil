<?php

namespace App\Imports;

use App\Models\Hasil;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HasilsImport implements ToModel,WithHeadingRow
{

    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       

        return new Hasil([
            'nama'     => $row['nama'],
           'nim'    => $row['nim'], 
           'class_id'    => $row['class_id'], 
           
        ]);
    }

    
} 