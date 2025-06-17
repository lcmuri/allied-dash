<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasRecursiveRelationships;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'status',
    ];

    /**
     * The medicines that belong to the category.
     */
    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'medicine_category');
    }

    /**
     * Get the parent category.
     * Required by staudenmeir/laravel-adjacency-list for recursive relationships.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the child categories.
     * Required by staudenmeir/laravel-adjacency-list for recursive relationships.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
