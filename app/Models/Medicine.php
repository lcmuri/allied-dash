<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Medicine extends Model
{
    /** @use HasFactory<\Database\Factories\MedicineFactory> */
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'generic_name',
        'status',
        'description',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * The categories that belong to the medicine.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'medicine_category');
    }

    public function strengths(): HasMany
    {
        return $this->hasMany(Strength::class);
    }

    public function doseForms()
    {
        return $this->belongsToMany(DoseForm::class, 'strengths')
            ->withPivot([
                'concentration_amount',
                'concentration_unit',
                'volume_amount',
                'volume_unit',
                'chemical_form',
                'info'
            ])
            ->using(Strength::class)
            ->withTimestamps();
    }

    // Updated accessor
    public function getStrengthsSummaryAttribute()
    {
        return $this->strengths->map(function ($strength) {
            return $strength->full_description;
        })->join(', ');
    }

    // public function atcCode()
    // {
    //     return $this->belongsTo(AtcCode::class);
    // }
    // public function doseForm()
    // {
    //     return $this->belongsTo(DoseForm::class);
    // }
    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }
    // public function scopeSearch($query, $searchTerm)
    // {
    //     return $query->where('name', 'like', "%{$searchTerm}%")
    //         ->orWhere('generic_name', 'like', "%{$searchTerm}%")
    //         ->orWhereHas('categories', function ($q) use ($searchTerm) {
    //             $q->where('name', 'like', "%{$searchTerm}%");
    //         });
    // }
    // public function scopeActive($query)
    // {
    //     return $query->where('status', 'active');
    // }
    // public function scopeInactive($query)
    // {
    //     return $query->where('status', 'inactive');
    // }
    // public function scopeWithCategory($query, $categoryId)
    // {
    //     return $query->whereHas('categories', function ($q) use ($categoryId) {
    //         $q->where('category_id', $categoryId);
    //     });
    // }
    // public function scopeWithAtcCode($query, $atcCodeId)
    // {
    //     return $query->where('atc_code_id', $atcCodeId);
    // }
    // public function scopeWithDoseForm($query, $doseFormId)
    // {
    //     return $query->whereHas('strengths', function ($q) use ($doseFormId) {
    //         $q->where('dose_form_id', $doseFormId);
    //     });
    // }
    // public function scopeWithStrength($query, $strengthId)
    // {
    //     return $query->whereHas('strengths', function ($q) use ($strengthId) {
    //         $q->where('id', $strengthId);
    //     });
    // }
    // public function scopeWithSlug($query, $slug)
    // {
    //     return $query->where('slug', $slug);
    // }
    // public function scopeWithGenericName($query, $genericName)
    // {
    //     return $query->where('generic_name', 'like', "%{$genericName}%");
    // }
    // public function scopeWithName($query, $name)
    // {
    //     return $query->where('name', 'like', "%{$name}%");
    // }
    // public function scopeWithDescription($query, $description)
    // {
    //     return $query->where('description', 'like', "%{$description}%");
    // }
    // public function scopeWithStatus($query, $status)
    // {
    //     return $query->where('status', $status);
    // }
}
