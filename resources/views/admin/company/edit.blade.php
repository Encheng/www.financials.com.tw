@extends('admin.layouts.cms_basic')

@section('title','公司編輯')

@section('content')
    <form action="{{ route('admin.company.update', ['id'=>$company->id]) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">公司編輯</h3>
            </div>
            @include('admin.company.form')
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">儲存</button>
            </div>
        </div>
    </form>
@endSection

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