<ol class="breadcrumb">
    @foreach($breadcrumbCollect as $item)
        <li>{{ $item->name }}</li>
    @endForeach
</ol>