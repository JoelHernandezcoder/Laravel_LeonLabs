<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionOrder extends Model
{
    /** @use HasFactory<\Database\Factories\ProductionOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'batch',
        'sale_id',
        'start_date',
        'original_start_date',
        'end_date',
        'original_end_date',
        'production_line_id'
    ];

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'medication_production_order')
            ->withPivot('quantity', 'sub_total');
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function line(): BelongsTo
    {
        return $this->belongsTo(ProductionLine::class, 'production_line_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function supplyOrders(): HasMany
    {
        return $this->hasMany(SupplyOrder::class);
    }
}

