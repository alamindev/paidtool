<?php

namespace App\Imports;

use App\Task;
use App\Package;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TaskUrlImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 
        $package = Package::find($row[0]);
        if ($package) {
            $task = new Task([
                'package_id'  => $row[0],
                'time'       => $row[1],
                'url'       => $row[2],
                'type' => 1
            ]);

            return $task;
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
