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
        'eps',
        'div',
        'roe',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
