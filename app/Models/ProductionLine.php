<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionLine extends Model
{
    /** @use HasFactory<\Database\Factories\ProductionLineFactory> */
    use HasFactory;

    public function order(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function employees(): HasMany
    {
        return $this->HasMany(Employee::class);
    }
}
