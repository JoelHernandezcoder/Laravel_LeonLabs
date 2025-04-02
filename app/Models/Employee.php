<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{

    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'address',
        'meal_option',
        'role',
        'seniority',
        'salary',
        'start_date',
    ];


    public function lines(): BelongsToMany
    {
        return $this->belongsToMany(ProductionLine::class, 'production_line_employee');
    }


}
