<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class FinancialStatement extends Model
{
    protected $table = 'financial_statements';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'company_id',
        'year',
        'eps',
        'div',
        'roe',
    ];

    public function company()
    {
        return $this->hasMany(Company::class);
    }
}
