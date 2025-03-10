<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entities\Company;
use App\Repositories\CompanyRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Validator;
use View;

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

        $year = date('Y'); // 未來可以提供選擇年份分析
        $company = Company::with(['companyFinancialStatement' => function ($query) use ($year) {
            $query->where('year', '>=', $year - 5)
                ->orderBy('year');
        }])
            ->find($id);

        if (count($company->companyFinancialStatement) < 5) {
            throw new Exception('財報數據不足以分析');
        }

        $roe_averages = $this->calculateAverageRoe($company);

        // TODO: RIR在投率
        // TODO: IRR內部報酬（年化率）
        $array = [];
        $past_irr = $this->irr([
            '-34.75', // 花費多少錢買（5年前的最高＋最低平均/2的股價）
            '2.65',
            '1.8',
            '1.95',
            '3.2',
            '2.54',
            '60.9', // 現在的股價
        ]);

        $feature_irr = $this->calculateFeatureIrr($company, $roe_averages);

        // 圖表製作
        $chart_columns = ['Year', 'ROE', '平均ROE', '好公司ROE標準'];
        $chart_data = $company->companyFinancialStatement->map(function ($item) use ($roe_averages) {
            return [$item->year, $item->roe, $roe_averages, 15];
        })->toArray();
        // insert $chart_columns to the beginning of $chart_data
        array_unshift($chart_data, $chart_columns);
        $chart_data = json_encode($chart_data);

        // AI prompt
        $ai_prompt = $this->AiPrompt($company, $roe_averages);

        return view(
            $this->getViewPath('analyze'),
            compact(
                'company',
                'roe_averages',
                'chart_data',
                'ai_prompt',
                'feature_irr'
            )
        );

        // TODO:
        // 要計算roe結果、計算（各種計算，要呈現分析結果）
        // 要符合指標就亮綠燈（roe平均大於15）
        // PER本益比＝今年EPS/現在股價，PER是否低於12(<12,<15)
        // RIR = 盈餘再投資率 有資料，但是還沒實作邏輯
        // GDP報表
    }

    public function import()
    {
        $data = [];
        $data['companies'] = ['0' => '請選擇'] + Company::orderBy('id')
            ->pluck('name', 'id')
            ->toArray();

        return view('admin.company.import.create', [
            'data' => $data,
        ]);
    }

    public function importProcess(Request $request)
    {
        // 處理导入財報資料處理的邏輯
        $msg_bag = new MessageBag();
        $rules = [
            // 'company_id' => 'required|not_in:0',
            'file' => 'required',
        ];
        $error_messages = [
            // 'company_id.not_in' => '請選擇公司',
            // 'company_id.required' => '請選擇公司',
            'file.required' => '請選擇匯入檔案',
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules, $error_messages);
        $company_id = intval($request->get('company_id'));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            //check excel format
            $tmp_file = $request->file('file')->getRealPath();
            $reader = IOFactory::createReaderForFile($tmp_file);
            $reader->setReadDataOnly(true);

            $excel = $reader->load($tmp_file);
            $sheets = $excel->getAllSheets();

            foreach ($sheets as $k => $sheet) {
                $max_cell = $sheet->getHighestRowAndColumn();
                $rows = $sheet->rangeToArray('A2:K' . $max_cell['row']); //忽略欄名,從A2開始
                $rows = array_map('array_filter', $rows);
                $rows = array_filter($rows);
                $insertItem = count($rows);
            }
        } catch (MessageBagException $ex) {
            return back()->withErrors($ex->getMessageBag())->withInput();
        } catch (Exception $ex) {
            $msg_bag->add(1, 'Excel 格式無法解析:' . $ex->getMessage());

            return back()->withErrors($msg_bag->all())->withInput();
        }

        // 整理excel資料
        // 1. 驗證欄位數量
        // 2. 整理excel資料
        foreach ($rows as $key => $value) {
            dd($value);
        }

        // 將excel資料寫進company_financial_statement資料表
        CompanyFinancialStatement::insert($rows);

        $message = '已進入排程，匯入完成後系統會email寄發通知您';
        return redirect()->to(route('admin.leader.member.index'))->withMessage($message);
    }

    public function irr($values, $guess = 0.1)
    {
        $count = count($values);
        $positive = false;
        $negative = false;

        foreach ($values as $value) {
            if ($value > 0) {
                $positive = true;
            } elseif ($value < 0) {
                $negative = true;
            }
        }

        if (!$positive || !$negative) {
            return null;
        }

        $irr = $guess;
        $epsilon = 1e-7;
        $maxIteration = 100;
        $iteration = 0;

        do {
            $irrOld = $irr;
            $npv = 0;

            for ($i = 0; $i < $count; $i++) {
                $npv += $values[$i] / pow(1 + $irr, $i);
            }

            $dNpv = 0;

            for ($i = 0; $i < $count; $i++) {
                $dNpv -= $values[$i] * $i / pow(1 + $irr, $i + 1);
            }

            $irr -= $npv / $dNpv;
            $iteration++;
        } while (abs($irr - $irrOld) > $epsilon && $iteration < $maxIteration);

        if ($iteration === $maxIteration) {
            return null;
        }

        return $irr;
    }

    /**
     * 計算未來IRR 年化率
     * ROE平均公式：((前四年的EPS相加/4 * 0.5) + (最後一年的eps * 0.5)) / NAV
     *
     * @param  Company $company
     * @param  double $average_roe
     * @return float
     */
    private function calculateFeatureIrr($company, $average_roe)
    {
        $eps_averages = $this->calculateAverageEps($company);
        // 目前平均的DIV
        $average_div = $company->companyFinancialStatement->avg('div');

        // 算出隔一年的NAV 股價淨值
        $feature_nav = $company->nav + $eps_averages - $average_div;
        // 算出隔一年eps
        $feature_eps = $feature_nav * $average_roe / 100;
        // 算出隔年div
        $feature_div = $feature_eps * ($average_div / $eps_averages);

        // 要計算未來8年的資料
        $years = 7;
        $features = [
            ['nav' => $feature_nav, 'eps' => $feature_eps, 'div' => $feature_div],
        ];

        for ($i = 0; $i < $years - 1; $i++) {
            $feature_nav = $features[$i]['nav'] + $features[$i]['eps'] - $features[$i]['div'];
            $feature_eps = $feature_nav * $average_roe / 100;
            $feature_div = $feature_eps * ($features[$i]['div'] / $features[$i]['eps']);

            $features[] = ['nav' => $feature_nav, 'eps' => $feature_eps, 'div' => $feature_div];
        }
        $eight_year_stock_price[] = $features[6]['eps'] * 12;

        // get $features array all key is div value.
        $feature_div_array = array_merge([$average_div], array_column($features, 'div'));
        $irr_array = [-$company->stock_price];

        $irr_array = array_merge($irr_array, $feature_div_array, $eight_year_stock_price);

        return $this->irr($irr_array);
    }

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

    // TODO: RIR公式
    // private function rir()
    // {

    // }

    // TODO: AI prompt 產生
    private function AiPrompt($company, $roe_averages)
    {
        $base_prompt = "我需要有資格、有經驗的人提供協助，能夠使用技術分析工具來理解圖表，並解釋全球宏觀經濟環境，從而幫助客戶獲取長期利益，需要明確的決策，因此希望通過精確的預測來獲得同樣的效果！";
        $question = "請依序回答以下問題，並給我總結，以及分析出我現在是否該投資這間公司。
            1.PER是否低於12(<12,<15)，佔比10分
            2.ROE是否高於15,保持持續向上(>15,持續向上)，佔比20分
            3.IRR是否高於15(>15)，佔比20分
            4.是否配息40%以上或買回股藏股(美股)DIV OR Buy Back，佔比10分
            5.董監持股或owner share是否高於10%，佔比5分
            6.Market Cap市值是否前三大(龍頭股滿分)，佔比5分
            7.RIR再投率是否低於80%(金融股例外)，佔比10分
            8.是否為簡單不變的企業(科技股等不簡單股0分)，佔比5分
            9.目前是否為GDP高點(高點0分,低點10分)，佔比10分
            10.常利(net income)在五億台幣或7千五百萬美元以上，佔比5分
        ";

        $result = "";
        foreach ($company->toArray() as $key => $company_info) {
            if (!is_array($company_info)) {
                $result .= $key . ": " . $company_info . ",\n";
            }
        }
        foreach ($company->toArray()['company_financial_statement'] as $company_financial_statement_infos) {
            foreach ($company_financial_statement_infos as $key => $company_financial_statement_info) {
                $result .= $key . ": " . $company_financial_statement_info . ",\n";
            }
        }
        $company_analyze_prompt = "該公司的財報資訊：" . $result;

        return $base_prompt . $company_analyze_prompt . $question;
    }

    /**
     * 好公司評分標準
     *
     * @return array
     */
    private function goodCompanyScoreList()
    {
        return [
            [
                'key' => '1.PER是否低於12(<12,<15)',
                'value' => '10',
            ],
            [
                'key' => '2.ROE是否高於15,保持持續向上(>15,持續向上)',
                'value' => '20',
            ],
            [
                'key' => '3.IRR是否高於15(>15)',
                'value' => '20',
            ],
            [
                'key' => '4.是否配息40%以上或買回股藏股(美股)DIV OR Buy Back',
                'value' => '10',
            ],
            [
                'key' => '5.董監持股或owner share是否高於10%',
                'value' => '5',
            ],
            [
                'key' => '6.Market Cap市值是否前三大(龍頭股滿分)',
                'value' => '5',
            ],
            [
                'key' => '7.RIR再投率是否低於80%(金融股例外)',
                'value' => '10',
            ],
            [
                'key' => '8.是否為簡單不變的企業(科技股等不簡單股0分)',
                'value' => '5',
            ],
            [
                'key' => '9.目前是否為GDP高點(高點0分,低點10分)',
                'value' => '10',
            ],
            [
                'key' => '10.常利在五億台幣或7千五百萬美元以上',
                'value' => '5',
            ],
        ];
    }

    /**
     * 取得準備批次匯入的 User Data
     *
     * @param array $file_data
     * @return array
     */
    private function formatPrepareInsertData($file_data)
    {
        $data = [];
        foreach ($file_data as $k => $row) {
            $data[$k] = [
                'company_account' => $row[0],
                'account' => $row[1],
                'user_edms' => $row[2],
            ];
        }
        return $data;
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
