@extends('admin.layouts.cms_basic')

@section('title','公司財報分析')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            {{-- <form action="{{ route('admin.company.index') }}" method="GET">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">公司篩選表單</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">編號</label>
                                    <input type="text" name="id" value="{{ $condition['id']??null }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">公司名稱</label>
                                    <input type="text" name="name" value="{{ $condition['name']??null }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">股票代號</label>
                                    <input type="text" name="stock_symbol" value="{{ $condition['stock_symbol']??null }}"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">產業別</label>
                                    <input type="text" name="industry" value="{{ $condition['industry']??null }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">股票發行地</label>
                                    <input type="text" name="stock_exchanges" value="{{ $condition['stock_exchanges']??null }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <div class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-primary">篩選</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form> --}}

            <div class="box">
                <div class="box-header ">
                    <h3 class="box-title ">公司列表</h3>
                </div>
                <div class="box-body ">
                    {{-- TODO: 要放入公司名稱、股票代碼、現在股價、PRE --}}
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>公司名稱:</label>
                                <p>{{ $company->name}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table role="grid" class="table table-bordered table-hover dataTable ">
                                <thead>
                                <tr role="row">
                                    <th class="col-md-2">年份</th>
                                    <th class="col-md-4">EPS</th>
                                    <th class="col-md-3">DIV</th>
                                    <th class="col-md-3">ROE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($company->companyFinancialStatement as $financial)
                                    <tr>
                                        <td>{{ $financial->year }}</td>
                                        <td>{{ $financial->eps }}</td>
                                        <td>{{ $financial->div }}</td>
                                        <td>{{ $financial->roe }}</td>
                                        {{-- <td>{{ $financial->stock_symbol }}</td>
                                        <td>{{ $financial->stock_exchanges }}</td> --}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="curve_chart" style="width: 900px; height: 500px"></div>

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
      $('.select2').select2({
        minimumResultsForSearch: Infinity,
        language: 'zh-TW',
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
          title: '公司財報分析圖表 RIR',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
@endSection