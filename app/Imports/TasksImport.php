<?php

namespace App\Imports;

use App\Task;
use App\Package;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TasksImport implements ToModel, WithStartRow
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
                'title'       => $row[1],
                'description' => $row[2]
            ]);

            return $task;
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
