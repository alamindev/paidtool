<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!User::whereEmail($row[1])->exists()) {
            return new User([
                'name'     => $row[0],
                'email'    => $row[1],
                'phone'    => $row[2],
                'country'  => $row[3],
                'address'  => $row[4],
                'password' => Hash::make("admin@123")
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
