@extends('admin.layouts.cms_basic')

@section('title', '公司列表')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.company.index') }}" method="GET">
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
            </form>

            <div class="box">
                <div class="box-header ">
                    <h3 class="box-title ">公司列表</h3>
                </div>
                <div class="box-body ">
                    <div class="row">
                        <div class="col-12">
                            <table role="grid" class="table table-bordered table-hover dataTable ">
                                <thead>
                                <tr role="row">
                                    <th class="col-md-1">編號</th>
                                    <th class="col-md-2">名稱</th>
                                    <th class="col-md-4">股票代號</th>
                                    <th class="col-md-3">股票發行地</th>
                                    <th>動作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $company)
                                    <tr>
                                        <td>{{ $company->id }}</td>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->stock_symbol }}</td>
                                        <td>{{ $company->stock_exchanges }}</td>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default"
                                                    onclick="javascript:location.href='{{route('admin.company.edit',$company->id)}}'">
                                                編輯
                                            </button>
                                            <button type="button" class="btn btn-default"
                                                    onclick="javascript:location.href='{{route('admin.company.analyze',$company->id)}}'">
                                                分析
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7 ">
                            <div class="dataTables_paginate paging_simple_numbers ">
                                {!! $list->appends($condition)->render() !!}
                            </div>
                        </div>
                    </div>
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
@endSection