<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionLine extends Model
{
    /** @use HasFactory<\Database\Factories\ProductionLineFactory> */
    use HasFactory;

    public function orders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class, 'production_line_id');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'production_line_employee');
    }

}
