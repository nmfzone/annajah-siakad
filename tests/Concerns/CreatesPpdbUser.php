<?php

namespace Tests\Concerns;

use App\Models\Ppdb;
use App\Models\PpdbUser;
use App\Models\User;

trait CreatesPpdbUser
{
    use CreatesPpdb;

    public function createPpdbUser(Ppdb $ppdb, User $user): PpdbUser
    {
        $selectionMethod = PpdbUser::factory()->make()['selection_method'];

        return $this->makePpdbService()
            ->addNewRegistrar($ppdb, $user, [
                'selection_method' => $selectionMethod,
            ]);
    }
}
