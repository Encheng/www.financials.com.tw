@extends('admin.layouts.cms_basic')

@section('title','公司財報分析')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">財報基本面</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">ROE</a>
                                    </li>
                                    <li>
                                        <a href="#tab_2" data-toggle="tab">IRR</a>
                                    </li>
                                    <li>
                                        <a href="#tab_3" data-toggle="tab">PER</a>
                                    </li>
                                    <li>
                                        <a href="#tab_4" data-toggle="tab">NAV</a>
                                    </li>
                                    <li>
                                        <a href="#tab_5" data-toggle="tab">EPS</a>
                                    </li>
                                    <li>
                                        <a href="#tab_6" data-toggle="tab">RIR</a>
                                    </li>
                                    <li>
                                        <a href="#tab_7" data-toggle="tab">GDP</a>
                                    </li>
                                    <li>
                                        <a href="#tab_8" data-toggle="tab">分析SOP</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <h4>ROE [Return On Equity]（股東權益報酬率）</h4>
                                        <blockquote>公司幫股東賺錢的效率</blockquote>
                                        <p>ROE 公式為：股東權益報酬率 = 稅後淨利(EPS) / 股東權益(NAV)</p>
                                        <p>
                                            請想像一隻母雞，每年能夠產下約5公斤的蛋，這種產出可以視為每股盈餘（EPS）。現在，這隻母雞的體重為淨重20公斤。</br>
                                            若我們將每股盈餘（5公斤的蛋）除以母雞的淨重（20公斤），我們得到了25%。這個25%便是ROE，或者說是股東權益報酬率，它類似於母雞生蛋的效率指標。</br>
                                            這個比喻也可以應用在評估一家上市公司或工廠的經濟效益。如果一家公司每年的獲利率達到25%，這是否被視為優秀的經營表現呢？通常，公司會保留約三成的獲利，然後根據市場狀況進行調整。若公司能夠實現25%的ROE，那麼可以認為這是一個相當優秀的表現。</br>
                                            ROE與股東權益的變動息息相關，就像母雞的體重會受到各種因素的影響一樣。舉例來說，去年由於防疫保單的賠款，許多財產保險公司的股東權益可能下降，這是因為他們需要支付賠償給投保防疫保單的客戶。</br>
                                            股東權益的變動可能會影響公司的股價。然而，也有一些公司，像是新產2850，即使股東權益變化不大，也不需要向股東籌措額外的資金，這使得它在去年以每股42-44元的價格穩定提醒投資者參與。</br>
                                            值得注意的是，毛利率和ROE是兩個不同的概念。毛利率是指在扣除所有運營成本後的純利率，而ROE涉及股東權益和總資產之間的關係。</br>
                                            最後，當我們談到巴菲特時，他曾說過若一家公司的ROE能夠保持在15%以上，那麼這是一家相當優秀的公司。舉例來說，台積電的ROE通常在25-30%左右，同時其毛利率約為50%左右，這使得它被視為一家高效益的公司。
                                        </p>
                                    </div>

                                    <div class="tab-pane" id="tab_2">
                                        <h4>IRR[internal rate of return]（內部報酬率）</h4>
                                        <blockquote>年化報酬率</blockquote>
                                        <p>
                                            是一種衡量投資收益率的評估方法，計算的原理是資產潛在的價值(Future value)以多少的折現率來計算，可以得到資產的現值(Present value)
                                        </p>
                                    </div>

                                    <div class="tab-pane" id="tab_3">
                                        <h4>PER [Rice-to-Earning Ratio]（本益比）</h4>
                                        <blockquote>買進股票後，多少年可以回本</blockquote>
                                        <p>PER公式 = 現在股價(Price) / 預估未來每年每股盈餘(EPS)</p>
                                        <p>
                                            當你已經評估完一間公司的體質與成長性沒問題之後，需要判斷價格是否貴或便宜，就可以使用這項指標。</br>
                                            一般來說，本益比數字越小代表股價越便宜，你的投資可以越快回本。</br>
                                            注意1. 正確的本益比計算應該使用「預估未來EPS」，但現實中我們大多是用「過去歷史EPS」</br>
                                            注意2. 虧損或是獲利高低很不穩定的股票，不適合用本益比評價</br>
                                        </p>
                                    </div>

                                    <div class="tab-pane" id="tab_4">
                                        <h4>NAV [Net Asst Value per Share]（每股資產淨值）</h4>
                                        <blockquote>股東在公司資產中所佔的實際權益</blockquote>
                                        <p>NAV公式: (總資產- 總負債)/總股數</p>
                                        <p>淨值 = (股本[資產\庫藏股] ＋ 保留盈餘[配息])</p>
                                        <p>
                                            舉例來說，公司總資產是100元，總負債是0，總股數是100股的話，公司的每股資產淨值就是1元，即每股擁有1元淨資產。</br>
                                            正常而言，排除其他因素，合理股價將會是1元，不過，實際上公司的股價是由市場決定，每股資產淨值不一定等同於公司股價才是合理。</br>
                                            當公司進行配息/減資時，NAV就會下降，而ROE就會上升。反之，當公司大量增資時，NAV大量上升，ROE急劇下降。</br>
                                            像是金融股，因為是以錢為生財工具，因此每年的營收增加，導致NAV上升，因此用配息給股東的方式，降低NAV，提升ROE。
                                        </p>
                                    </div>

                                    <div class="tab-pane" id="tab_5">
                                        <h4>EPS [Earnings Per Share]（內部報酬率）</h4>
                                        <blockquote>企業能為每一股的股票賺進多少錢</blockquote>
                                        <p>EPS的公式： 稅後淨利 / 在外流通普通股股數</p>
                                        <p>
                                            稅後淨利為：公司當年度賺得的收入扣除成本、費用與稅之後，剩下的利潤。</br>
                                            在外流通普通股股數為：一間公司在公開發行市場上所有流通的股票，包含投資人持有、公司內部人與員工持有、三大法人持有的普通股總數。</br>
                                            每股盈餘的計算，主要就是基於公司的稅後淨利而來，而稅後淨利的來源，主要是來自公司本業的獲利之外，也可能是公司業外的投資收益、或是一次性獲利認列 (如出售土地、廠房設備) 等等。
                                        </p>
                                    </div>

                                    <div class="tab-pane" id="tab_6">
                                        <h4>RIR [Reinvestment Rate]（再投資率）</h4>
                                        <blockquote>企業能為每一股的股票賺進多少錢</blockquote>
                                        <p>RIR的公式：(固資5 - 固資1) + (長投5 - 長投1) / 淨利1+淨利2+淨利3+淨利4+淨利5</p>
                                        <p>
                                            再投資率越高，公司擴大經營能力越強，反之則越弱</br>
                                            一般公司的RIR再投率是否有低於80%，如果再投率太高代表賺到的錢都拿去投資，沒錢給股東 (金融股例外，因為銀行錢最多)
                                        </p>
                                    </div>

                                    <div class="tab-pane" id="tab_7">
                                        <h4>GDP [Gross Domestic Product]（國內生產總額）</h4>
                                        <blockquote>GDP高點要賣出，GDP低點要買入</blockquote>
                                        <p>
                                            GDP高點時，建議先減碼1/3。若股價也變貴了，再賣更多</br>
                                            GDP低點時，持股比率不宜低於1/3。若股價仍不夠便宜則持股最多5成
                                        </p>
                                        <p>
                                            只要買在GDP年增率最低的那一季，即便不是指數的最低點，仍然會落在底部附近
                                        </p>
                                    </div>

                                    <div class="tab-pane" id="tab_8">
                                        <h4>投資SOP</h4>
                                        <blockquote>依序以下步驟進行，可以找到好公司長期投資</blockquote>
                                        <p>1. 透過財報狗，台股(ROE > 15%、PER < 12)，美股(ROE > 15%、PER < 10）</p>
                                        <p>2. 挑選有興趣的股票，分析並觀測財報。要有好的ROE（平均10-15%），較低的R/E（12-15內），以及15%以上的irr，才是值得投資的股票，（除了金融產業外，需要低RIR）</p>
                                        <p>3. 觀測該公司的產業特色、主要產品，以及找出為什麼要選這間公司投資</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TODO: 建立一buttom 如何選好股票
                a. 穩定現金流：認真工作，現金流維持基本生活，多餘存錢投資。
                b. 投資高IRR公司，增加資本利得
                c. 根據ROE判斷好公司，篩選可投資公司。
            --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">公司基本資訊</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {{-- 公司名稱、股票代碼、現在股價、PER --}}
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">公司名稱：</label>
                                <p>{{ $company->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">股票代號：</label>
                                <p>{{ $company->stock_symbol }}</p>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">股票發行地：</label>
                                <p>{{ $company->stock_exchanges }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">目前股價：</label>
                                <p>{{ $company->stock_price }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">股票淨值(NAV)：</label>
                                <p>{{ $company->nav }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" data-toggle="tooltip" title="台股要小於12, 美股要小於10">本益比(PER)：</label>
                                <p>{{ $company->per }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" data-toggle="tooltip" title="要大於15">平均ROE：</label>
                                <p>{{ round($roe_averages, 2) }}%</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">未來投資報酬率 IRR：</label>
                                <p>{{ round($feature_irr, 2) * 100 }}%</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">AI分析prompt：</label>
                                <input type="hidden" id="ai_prompt" value="{{ $ai_prompt }}"/>
                                <button class="btn btn-block btn-primary btn-sm" id="copyButton">生成</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="box-header ">
                    <h3 class="box-title ">公司財報分析</h3>
                </div>
                <div class="box-body ">
                    <div class="row">
                        <div class="col-6">
                            <table role="grid" class="table table-bordered table-hover dataTable ">
                                <thead>
                                <tr role="row">
                                    <th class="col-md-1">年份</th>
                                    <th class="col-md-1">EPS</th>
                                    <th class="col-md-1">DIV</th>
                                    <th class="col-md-1">ROE</th>
                                    <th class="col-md-1">淨利</th>
                                    <th class="col-md-2">固定資產</th>
                                    <th class="col-md-2">長期資產</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($company->companyFinancialStatement as $financial)
                                    <tr>
                                        <td>{{ $financial->year }}</td>
                                        <td>{{ $financial->eps }}</td>
                                        <td>{{ $financial->div }}</td>
                                        <td>{{ $financial->roe }}</td>
                                        <td>{{ $financial->net_income }}</td>
                                        <td>{{ $financial->fixed_assets }}</td>
                                        <td>{{ $financial->non_current_assets }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-4">
                            <table role="grid" class="table table-bordered table-hover dataTable ">
                            <tr role="row">
                                <th>好公司評分表</th>
                                <th class="col-md-2">分數比例</th>
                            </tr>
                            <tr>
                                <td>1.PER是否低於12(&lt;12,&lt;15)</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>2.ROE是否高於15,保持持續向上(&gt;15,持續向上)</td>
                                <td>20</td>
                            </tr>
                            <tr>
                                <td>3.IRR是否高於15(&gt;15)</td>
                                <td>20</td>
                            </tr>
                            <tr>
                                <td>4.是否配息40%以上或買回股藏股(美股)DIV OR Buy Back</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>5.董監持股或owner share是否高於10% (可以去財報狗看)</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>6.Market Cap市值是否前三大(龍頭股滿分)</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>7.RIR再投率是否低於80%(金融股例外)</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>8.是否為簡單不變的企業(科技股等不簡單股0分)</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>9.目前是否為GDP高點(高點0分,低點10分)</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>10.常利在五億台幣或7千五百萬美元以上</td>
                                <td>5</td>
                            </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div id="curve_chart" style="width: 900px; height: 500px"></div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-sm-7 ">
                            <div class="dataTables_paginate paging_simple_numbers ">
                                {!! $list->appends($condition)->render() !!}
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script type="text/javascript">
    $(document).ready(function () {
        $("[data-toggle='tooltip']").tooltip();

        $('.select2').select2({
            minimumResultsForSearch: Infinity,
            language: 'zh-TW',
        });

        $('.nav-tabs a').click(function() {
            $('.nav-tabs li').removeClass('active');
            $(this).parent('li').addClass('active');
        });

        $("#copyButton").click(function() {
            // 取得要複製的值
            var inputField = $("#ai_prompt");
            var textToCopy = inputField.val();

            // 建立一個臨時输入框並添加到頁面
            var tempInput = $("<input>");
            $("body").append(tempInput);

            // 將值設定為要複製的資料
            tempInput.val(textToCopy);

            // 找出臨時输入框的資料
            tempInput.select();

            // 複製資料到剪貼板
            document.execCommand("copy");

            // 刪除臨時输入框
            tempInput.remove();

            // 提示複製成功
            alert("已產出並複製，請至Bard查看分析結果");
        });
    });
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      var chartData = {!! $chart_data !!};

      function drawChart() {
        var data = google.visualization.arrayToDataTable(chartData);

        // sample:
        // var data = google.visualization.arrayToDataTable([
        //   ['Year', 'ROE', 'Expenses'],
        //   ['2004',  1000,      400],
        //   ['2005',  1170,      460],
        //   ['2006',  660,       1120],
        //   ['2007',  1030,      540]
        // ]);

        var options = {
          title: '公司ROE指數型圖表',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
@endSection