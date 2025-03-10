<?php

namespace App\Services\Company;

use App\Repositories\CompanyRepository;

class CompanyService
{
    public function __construct(
        protected CompanyRepository $companyRepository
    ) {
    }

    public function getCompanyAccountCountInfo(int $idCompany)
    {
    }
}
