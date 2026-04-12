<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPlan extends Model
{
    protected $fillable = [
        'name',
        'return_rate',
        'return_duration',
        'min_amount',
        'max_amount',
        'badge_text',
        'features',
        'cta_text',
        'cta_url',
        'sort_order',
        'is_recommended',
        'is_active',
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getFeaturesAttribute($value)
    {
        $decoded = json_decode((string) $value, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function setFeaturesAttribute($value)
    {
        $features = is_array($value) ? $value : [];
        $features = array_values(array_filter(array_map('trim', $features), function ($item) {
            return $item !== '';
        }));

        $this->attributes['features'] = json_encode($features);
    }
}

