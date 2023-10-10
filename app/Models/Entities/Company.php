<?php

namespace App\Models\Entities;

use App\Models\Entities\BasicScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use BasicScopeTrait;

    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'stock_symbol',
        'industry',
        'introduction',
        'stock_exchanges',
        'stock_price',
        'nav',
    ];

    public function companyFinancialStatement()
    {
        return $this->hasMany(CompanyFinancialStatement::class);
    }
}
