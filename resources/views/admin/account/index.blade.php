@extends('admin.layouts.cms_basic')

@section('title', '帳號列表')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.accounts.index') }}" method="GET">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">帳號篩選表單</h3>
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
                                    <label for="">帳號</label>
                                    <input type="text" name="email" value="{{ $condition['email']??null }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">名稱、備註</label>
                                    <input type="text" name="search" value="{{ $condition['search']??null }}"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">群組</label>
                                    <select name="role" class="form-control select2"
                                            style="width: 100%;">
                                        <option value="">不限定</option>
                                        @foreach($roleList as $key=>$name)
                                            <option value="{{ $key }}"
                                                    {{ (($condition['role'] ?? null) == $key)?'selected':'' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                    <h3 class="box-title ">帳號列表</h3>
                </div>
                <div class="box-body ">
                    <div class="row">
                        <div class="col-12">
                            <table role="grid" class="table table-bordered table-hover dataTable ">
                                <thead>
                                <tr role="row">
                                    <th class="col-md-1">編號</th>
                                    <th class="col-md-2">名稱</th>
                                    <th class="col-md-4">帳號</th>
                                    <th class="col-md-3">群組</th>
                                    <th>動作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->id }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ implode(',', $admin->present()->getRolesDisplayName()) }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default"
                                                    onclick="javascript:location.href='{{route('admin.accounts.edit',$admin->id)}}'">
                                                編輯
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
                                {!! $admins->appends($condition)->render() !!}
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