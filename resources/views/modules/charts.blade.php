<ul class="nav nav-tabs {{ $theme }}" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="line-tab" data-toggle="tab" href="#line" role="tab" aria-controls="line" aria-selected="true">Past Spending</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pie-tab" data-toggle="tab" href="#pie" role="tab" aria-controls="line" aria-selected="false">Categories</a>
    </li>
</ul>
<div class="tab-content {{ $theme }}" id="myTabContent">
    <div class="tab-pane fade show active" id="line" role="tabpanel" aria-labelledby="line-tab">
        @include('modules.line-chart')
    </div>
    <div class="tab-pane fade" id="pie" role="tabpanel" aria-labelledby="pie-tab">
        @include('modules.actuals-pie-chart', ['categories' => $categories, 'actuals' => $actuals])
    </div>
</div>
