<?php

namespace App\Models;

use App\Garages\Utility\Unique;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function parents()
    {
        return $this->parent()->with('parents');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public static function generateSlug($name): string
    {
        $slug = Str::slug($name);
        $prefix = $slug . '-';

        $generate = function ($index) use ($slug, $prefix) {
            if ($index == 0) {
                return $slug;
            }

            return $prefix . $index;
        };

        $count = Category::where('slug', 'like', $prefix . '%')
            ->count();

        return Unique::generate(
            Category::class,
            $generate,
            'slug',
            $count == 0 ? -1 : $count
        );
    }
}
