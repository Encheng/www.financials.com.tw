<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
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

    public function financialStatement()
    {
        return $this->hasMany(financialStatement::class);
    }
}
