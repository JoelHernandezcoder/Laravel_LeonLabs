<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'total',
        'agreed_date',
        'is_delivered',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class,'medication_production_order');
    }

    public function medications(): BelongsToMany
    {
        return $this->belongsToMany(Medication::class, 'medication_sale')
            ->withPivot('units', 'sub_total');
    }

    public function calculateTotal()
    {
        return $this->medications->sum('pivot.sub_total');
    }

    public function updateTotal()
    {
        $total = $this->medications->sum(function($medication) {
            return $medication->pivot->sub_total;
        });
        $this->update(['total' => $total]);
    }

    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Shipping::class);
    }
}
