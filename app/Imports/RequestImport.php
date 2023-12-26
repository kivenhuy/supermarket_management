<?php

namespace App\Imports;

use Illuminate\Support\Collection;
    use Maatwebsite\Excel\Concerns\ToCollection;
    
class RequestImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
    }
}