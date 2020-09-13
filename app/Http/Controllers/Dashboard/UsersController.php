<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request, $userType)
    {
        $this->authorize('viewAny', [User::class, $userType]);

        $datatable = new UsersDataTable($request->user(), $userType);

        return $datatable->render('dashboard.users.index', compact('userType'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('dashboard.users.create');
    }

    public function store(UserCreateRequest $request)
    {
        $user = (new User)->newInstance($request->validated());
        $user->role = $request->role;
        $user->save();

        flash('Berhasil menambahkan pengguna.')->success();

        return redirect(route('dashboard.users.index', $request->role));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('dashboard.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('dashboard.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        flash('Berhasil memperbarui pengguna.')->success();

        return redirect(route('dashboard.users.index', $user->role));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->role == Role::ADMIN) {
            flash('Tidak bisa menghapus pengguna ini.')->error();
        } else {
            try {
                $user->delete();
                flash('Berhasil menghapus pengguna.')->success();
            } catch (Exception $e) {
                report($e);
                flash('Gagal menghapus pengguna.')->error();
            }
        }

        return redirect(route('dashboard.users.index', $user->role));
    }
}
