<!DOCTYPE html>
<html>
    <head>
        <title>import</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>{{config('env.app_name_large')}}公司財報批次匯入</h1>
        <p>公司編號:{{$company->idCompany}}</p>
        <p>公司名稱:{{$company->companyName}}</p>
        <h3>處理訊息</h3>
        <ul>
            @foreach($messages as $key => $val)
            <li>{{$key}}:{{$val}}</li>
            @endForeach
        </ul>
        @if(count($errors))
        <h3>錯誤訊息</h3>
        <ul>
            @foreach($errors as $key => $val)
            <li>{{$val}}</li>
            @endForeach
        </ul>
        @endif
    </body>
</html>
