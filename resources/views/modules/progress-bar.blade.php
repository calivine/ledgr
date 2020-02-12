<div class='progress'>
    <div class='progress-bar bg-success' role='progressbar' style='width: {{ ($monthly_expenditure / $monthly_budget) * 100 }}%' aria-valuenow='{{ $monthly_expenditure }}' aria-valuemin='0' aria-valuemax='{{ $monthly_budget }}'></div>
</div>