<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category)
    {
        if ($category->slug == null) {
            $category->slug = Category::generateSlug($category->name);
        }
    }

    public function updating(Category $category)
    {
        if ($category->slug == null) {
            $category->slug = Category::generateSlug($category->name);
        }
    }
}
