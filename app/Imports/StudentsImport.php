<?php

namespace App\Imports;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StudentsImport implements ToModel, WithChunkReading, ShouldQueue
{
    use Importable;

    public function model(array $row)
    {
        if (empty(trim($row[0]))) {
            Cache::forever('excel.students_import.start_year', $row[1]);
            return null;
        }

        $value = Cache::get('excel.students_import.start_year');

        $user = User::where('username', 'like', $value . '%')
            ->where('name', $row[1])
            ->where('role', Role::STUDENT)
            ->first();

        if ($user) {
            return null;
        }

        return new User([
            'name' => $row[1],
            'password' => bcrypt('12345678'),
            'username' => User::generateUsername(Role::STUDENT, $value),
            'role' => Role::STUDENT,
        ]);
    }

    public function batchSize(): int
    {
        return 20;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
