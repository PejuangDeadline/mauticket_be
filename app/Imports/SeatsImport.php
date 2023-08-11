<?php

namespace App\Imports;

use App\Models\Seat;
use Maatwebsite\Excel\Concerns\ToArray;

class SeatsImport implements ToArray
{
    public function array(array $rows)
    {
        return $rows;
    }
}
