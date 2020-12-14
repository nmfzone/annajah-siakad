<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $this->onlyAcceptedStudent($user);
    }

    public function view(User $user, Article $article): bool
    {
        return $article->author->is($user) || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $this->onlyAcceptedStudent($user);
    }

    public function update(User $user, Article $article): bool
    {
        return $this->onlyAcceptedStudent($user) && ($article->author->is($user) || $user->isAdmin());
    }

    public function publishArticle(User $user, Article $article): bool
    {
        return $this->onlyAcceptedStudent($user) && ($article->author->is($user) || $user->isAdmin());
    }

    public function delete(User $user, Article $article): bool
    {
        return $this->onlyAcceptedStudent($user) && ($article->author->is($user) || $user->isAdmin());
    }

    public function restore(User $user, ?Article $article = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return $user->isAdmin();
    }

    protected function onlyAcceptedStudent(User $user): bool
    {
        $site = site();

        if ($user->isStudent()) {
            if (is_null($site)) {
                return false;
            } else {
                $student = $user->studentProfileFor($site);

                if (is_null($student) || ! $student->isAccepted()) {
                    return false;
                }
            }
        }

        return true;
    }
}
