<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Strength extends Model
{
    //    use SoftDeletes;

    protected $fillable = [
        'medicine_id',
        'dose_form_id',
        'concentration_amount',
        'concentration_unit',
        'volume_amount',
        'volume_unit',
        'chemical_form',
        'info',
        'description'
    ];

    protected $casts = [
        'concentration_amount' => 'decimal:3',
        'volume_amount' => 'decimal:3',
    ];

    /**
     * Get the medicine that owns the strength
     */
    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    /**
     * Get the dose form for the strength
     */
    public function doseForm(): BelongsTo
    {
        return $this->belongsTo(DoseForm::class);
    }

    /**
     * Format the strength as a string
     */
    public function getFormattedStrengthAttribute(): string
    {
        $strength = $this->concentration_amount . $this->concentration_unit;

        if ($this->chemical_form) {
            $strength .= ' (' . $this->chemical_form . ')';
        }

        if ($this->volume_amount && $this->volume_unit) {
            $strength .= '/' . $this->volume_amount . $this->volume_unit;
        }

        if ($this->info) {
            $strength .= ' - ' . $this->info;
        }

        return $strength;
    }

    /**
     * Get the full description including dose form
     */
    public function getFullDescriptionAttribute(): string
    {
        return $this->doseForm->name . ' ' . $this->formatted_strength;
    }

    // public function doseForm()
    // {
    //     return $this->belongsTo(DoseForm::class);
    // }
    // public function getRouteKeyName(): string
    // {
    //     return 'id'; // or 'slug' if you have a slug field
    // }
    // public function scopeSearch($query, $searchTerm)
    // {
    //     return $query->where('concentration_amount', 'like', "%{$searchTerm}%")
    //         ->orWhere('concentration_unit', 'like', "%{$searchTerm}%")
    //         ->orWhere('volume_amount', 'like', "%{$searchTerm}%")
    //         ->orWhere('volume_unit', 'like', "%{$searchTerm}%")
    //         ->orWhere('chemical_form', 'like', "%{$searchTerm}%")
    //         ->orWhere('info', 'like', "%{$searchTerm}%")
    //         ->orWhere('description', 'like', "%{$searchTerm}%");
    // }
    // public function scopeFilterByMedicine($query, $medicineId)
    // {
    //     return $query->where('medicine_id', $medicineId);
    // }
}
