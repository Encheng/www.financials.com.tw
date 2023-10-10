<?php

namespace App\Console\Commands;

use App\Services\NavItem\NavItemService;
use Illuminate\Console\Command;
use App\Models\Entities\Company;
use App\Models\Entities\CompanyFinancialStatement;

class CalculateCompanyFinancial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:company_financial {--company_ids=*}';

    /**
     * The console command description.
     * php artisan calculate:company_financial --company_ids=1 --company_ids=2
     *
     * @var string
     */
    protected $description = 'calculate company financial.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 在執行這個command前，要先匯入該公司5年的
        $company_ids = $this->option('company_ids');

        // TODO: 可以抽成service比較簡潔
        // 要更新公司的ROE資料
        Company::with('companyFinancialStatement')
            ->whereIn('id', $company_ids)
            ->chunk(100, function ($companies) {
                foreach ($companies as $company) {
                    foreach ($company->companyFinancialStatement as $financial) {
                        // ROE = eps/nav*100
                        $financial->roe = $financial->eps / $company->nav * 100;
                        // update $financial
                        $financial->save();
                    }
                    $first_financial_statement = $company->companyFinancialStatement()
                        ->orderBy('year', 'desc')
                        ->first();

                    $company->per = $company->stock_price / $first_financial_statement->eps;
                    $company->save();
                }
            });
        $this->info('company financial calculated.');
    }
}
