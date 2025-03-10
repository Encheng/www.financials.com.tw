@extends('admin.layouts.cms_basic')

@section('title', '公司批次匯入')

@section('content')
<form action="{{ route('admin.company.financial.import.process') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">批次匯入公司財報</h3>
        </div>
        <div class="box-body">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="file">檔案: *</label>
                    <input type="file" id="file" name="file"
                        class="form-control select2">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">執行匯入</button>
        </div>
    </div>
</form>

<div class="box box-solid">
    <div class="box-header with-border">
        <i class="icon fa fa-info"></i>
        <h3 class="box-title">範例檔說明</h3>
        <a href="{{secure_asset('assets/company_financial_import_sample.xlsx')}}">點此下載範例檔</a>
    </div>
    <div class="box-body">
        <ul>
            <li>系統只會處理第一張工作表</li>
            <li>第一列為欄名</li>
            <li>第一列不可刪除</li>
            <li>欄位不可調整順序</li>
            <li>欄位不可自行新增</li>
            <li>檔案格式最高支援度為xlsx</li>
        </ul>
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