<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medication extends Model
{
    /** @use HasFactory<\Database\Factories\MedicationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'photo'
    ];

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'medication_sale')
            ->withPivot('quantity', 'sub_total');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(ProductionOrder::class, 'medication_production_order')
            ->withPivot('quantity', 'sub_total');
    }
}
