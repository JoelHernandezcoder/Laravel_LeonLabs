<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionOrder extends Model
{
    /** @use HasFactory<\Database\Factories\ProductionOrderFactory> */
    use HasFactory;

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function line(): BelongsTo
    {
        return $this->belongsTo(ProductionLine::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function supply_orders(): HasMany
    {
        return $this->hasMany(SupplyOrder::class);
    }
}
