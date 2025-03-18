<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplyOrder extends Model
{
    /** @use HasFactory<\Database\Factories\SupplyOrderFactory> */
    use HasFactory;

    public function production_order(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }
}
