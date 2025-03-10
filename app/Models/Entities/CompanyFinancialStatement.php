<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class CompanyFinancialStatement extends Model
{
    protected $table = 'company_financial_statements';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'company_id',
        'year',
        'highest_price',
        'lowest_price',
        'eps',
        'div',
        'roe',
        'net_income',
        'non_current_assets',
        'fixed_assets',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
