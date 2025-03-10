<?php

namespace App\Services\Migration;

use App;

trait FinancialTrait
{
    /**
     * ROE平均公式：((前四年的EPS相加/4 * 0.5) + (最後一年的eps * 0.5)) / NAV
     *
     * @param  Company $company
     * @return float
     */
    private function calculateAverageRoe($company)
    {
        $eps_averages = $this->calculateAverageEps($company);
        $roeAverages = $eps_averages / $company->nav * 100;

        return $roeAverages;
    }

    /**
     * 計算近五年的EPS平均
     * 公式：前四年eps相加/4 * 0.5 + 最後一年eps * 0.5
     *
     * @param  mixed $company
     * @return double $eps_averages
     */
    private function calculateAverageEps($company)
    {
        $financialStatements = $company->companyFinancialStatement;
        $epsSum = $financialStatements->sum('eps');
        $lastEps = $financialStatements->last()->eps;
        return (($epsSum - $lastEps) / 4 * 0.5) + ($lastEps * 0.5);
    }
}
