<?php

namespace App\Models\Concerns;

use App\Models\Site;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasProfiles
{
    public function teacherProfiles(): MorphToMany
    {
        return $this->morphedByMany(Teacher::class, 'userable')
            ->withPivot('site_id');
    }

    public function studentProfiles(): MorphToMany
    {
        return $this->morphedByMany(Student::class, 'userable')
            ->withPivot('site_id');
    }

    public function studentProfileFor(Site $site): ?Student
    {
        return $this->studentProfiles
            ->where('pivot.site_id', $site->id)
            ->first();
    }

    public function teacherProfileFor(Site $site): ?Teacher
    {
        return $this->teacherProfiles
            ->where('pivot.site_id', $site->id)
            ->first();
    }

    public function scopeStudents(Builder $query, Site $site = null): Builder
    {
        return $query->whereHas('studentProfiles', function (Builder $query) use ($site) {
            if ($site) {
                $query->where('userables.site_id', $site->id);
            }
        });
    }

    public function scopeAcceptedStudents(Builder $query, Site $site): Builder
    {
        return $query->whereHas('studentProfiles', function (Builder $query) use ($site) {
            $query->where('userables.site_id', $site->id)
                ->whereNotNull('accepted_at');
        });
    }
}
