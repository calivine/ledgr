<div class="accordion" id="accordionExample">
    <div class="card" width="75" height="75">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0 text-center">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Show Chart
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row justify-content-center">
                        @include('modules.actuals-pie-chart', ['categories' => $categories, 'actuals' => $actuals])
                </div>
            </div>
        </div>
    </div>
</div>
