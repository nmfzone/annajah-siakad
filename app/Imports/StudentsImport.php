<?php

namespace App\Imports;

use App\Enums\Role;
use App\Models\Site;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;

class StudentsImport implements WithChunkReading, OnEachRow, ShouldQueue
{
    use Importable,
        SerializesModels;

    /**
     * @var \App\Models\Site
     */
    protected $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();

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

        /** @var \App\Models\User $user */
        $user = $this->site->users()->save(new User([
            'name' => $row[1],
            'password' => bcrypt('12345678'),
            'role' => Role::STUDENT,
        ]));

        $user->studentProfiles()->save(
            new Student([
                'nis' => Student::generateNis($this->site),
            ]),
            ['site_id' => $this->site->id]
        );
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
