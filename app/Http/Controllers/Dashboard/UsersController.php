<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserUpdateUserableRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use HasSiteContext;

    public function index(Request $request, $subDomain, $userType)
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
        $this->site()->users()->save($user);

        flash('Berhasil menambahkan pengguna.')->success();

        return redirect(sub_route('dashboard.users.index', $request->role));
    }

    public function show($subDomain, User $user)
    {
        $this->userShouldBelongsToCurrentSite($user, 404, true);
        $this->authorize('view', $user);

        return view('dashboard.users.show', compact('user'));
    }

    public function edit($subDomain, User $user)
    {
        $this->userShouldBelongsToCurrentSite($user, 404, true);
        $this->authorize('update', $user);

        return view('dashboard.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, $subDomain, User $user)
    {
        $this->userShouldBelongsToCurrentSite($user, 404, true);
        $user->update($request->validated());

        if ($request->get('_context') == 'profile') {
            flash('Berhasil memperbarui identitas Anda.')->success();
            return redirect()->back();
        }

        flash('Berhasil memperbarui identitas pengguna.')->success();

        if ($user->isSuperAdmin()) {
            return redirect()->back();
        }

        return redirect(sub_route('dashboard.users.index', $user->role));
    }

    public function updateUserable(UserUpdateUserableRequest $request, $subDomain, User $user)
    {
        $this->userShouldBelongsToCurrentSite($user);

        if ($user->studentProfiles->isEmpty() &&
            $user->teacherProfiles->isEmpty()) {
            abort(404);
        }

        $model = null;
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();

        if ($user->teacherProfiles->isNotEmpty()) {
            $model = $user->teacherProfileFor($this->site());
        } elseif ($user->studentProfiles->isNotEmpty()) {
            $model = $user->studentProfileFor($this->site());
        }

        $model->update($request->validated());

        if ($user->isStudent()) {
            if ($authUser->isSuperAdminOrAdmin()) {
                flash('Berhasil memperbarui data akademik pengguna.')->success();
            } else {
                flash('Berhasil memperbarui data akademik.')->success();
            }
        } else {
            flash('Berhasil memperbarui data.')->success();
        }

        if ($request->get('_context') == 'profile') {
            return redirect()
                ->back()
                ->with('bottom-message', true);
        }

        return redirect(sub_route('dashboard.users.index', $user->role));
    }

    public function destroy($subDomain, User $user)
    {
        $this->userShouldBelongsToCurrentSite($user);
        $this->authorize('delete', $user);

        if ($user->isSuperAdmin() || $user->isAdmin()) {
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

        return redirect(sub_route('dashboard.users.index', $user->role));
    }
}
