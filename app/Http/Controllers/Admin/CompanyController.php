<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Entities\Company;
use View;
use Exception;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyRepository $company_repository
        // protected CompanyService $company_service
    ) {
        $this->template = [
            'url' => [
                'index' => route($this->getRouteName('index')),
                'edit' => route($this->getRouteName('edit'), ':id:'),
                'update' => route($this->getRouteName('update'), ':id:'),
            ],
            'list' => [
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $template = $this->template;
        $columns = ['id', 'name', 'stock_symbol', 'industry', 'stock_exchanges'];
        $condition = [
            'id' => $request->id,
            'name' => $request->name,
            'stock_symbol' => $request->stock_symbol,
            'industry' => $request->industry,
            'stock_exchanges' => $request->stock_exchanges,
        ];

        $list = $this->company_repository->getByCondition($columns, $condition);
        $model = new Company();

        return view($this->getViewPath('index'), compact('template', 'condition', 'list', 'model'));
    }

    public function create()
    {
        // 處理建立新公司的邏輯
    }

    public function store(Request $request)
    {
        // 處理儲存新公司的邏輯
    }

    public function edit($id)
    {
        // 可以編輯股價、NAV、公司歷年財報數值eps div
    }

    public function update(Request $request, $id)
    {
        // 處理更新公司資料的邏輯
    }

    public function financialCreate()
    {
        // 處理建立財報資料的邏輯
        // 第一步：查詢當前股價、淨值
        // https://goodinfo.tw/tw/StockBzPerformance.asp?STOCK_ID=2850
        // 假設2022年份，EPS要填2022年的數據，DIV則是要填2023年的數據
    }

    public function financialStore(Request $request)
    {
        // 處理儲存財報資料的邏輯
    }

    public function analyze($id)
    {
        // TODO: O 要可以選擇查看的年份資料 預設五年

        $year = date('Y');
        $company = Company::with(['companyFinancialStatement' => function ($query) use ($year) {
                $query->where('year', '>=', $year - 5)
                    ->orderBy('year');
            }])
            ->find($id);
        $roe_averages = $company->companyFinancialStatement->avg('roe');

        // 圖表製作
        $chart_columns = ['Year', 'ROE', 'EPS', '標準值'];
        $chart_data = $company->companyFinancialStatement->map(function ($item) {
                return [$item->year, $item->roe, $item->eps, 15];
        })->toArray();
        // insert $chart_columns to the beginning of $chart_data
        array_unshift($chart_data, $chart_columns);
        $chart_data = json_encode($chart_data);

        return view($this->getViewPath('analyze'), compact('company', 'roe_averages', 'chart_data'));

        // TODO: 要計算roe結果、計算（各種計算，要呈現分析結果）
        // 要符合指標就亮綠燈（roe平均大於15）
        // PER本益比＝今年EPS/現在股價，PER是否低於12(<12,<15)
        // RIR = 盈餘再投資率
        // GDP報表
    }

    public function import()
    {
        // 處理导入財報資料的邏輯
    }

    public function importProcess(Request $request)
    {
        // 處理导入財報資料處理的邏輯
    }

    /**
     * @param string $page
     *
     * @return string
     * @throws Exception
     */
    protected function getViewPath($page)
    {
        $path = "admin.company.{$page}";

        if (!View::exists($path)) {
            throw new Exception('blade not exists.');
        }

        return $path;
    }

    /**
     * @param string $page
     *
     * @return string
     */
    protected function getRouteName($page)
    {
        return "admin.company.{$page}";
    }
}
