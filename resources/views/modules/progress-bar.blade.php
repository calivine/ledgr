<div class='progress' style='height: 40px; font-size: 20px'>
<div class='progress-bar bg-{{ $data["color"] }} {{ $data["color"] == 'warning' ? 'text-body' : '' }}' role='progressbar' style='width: {{ $data["percent"] }}%' aria-valuenow='{{ $data["actual_total"] }}' aria-valuemin='0' aria-valuemax='{{ $data["planned_total"] }}'>{{ $data["percent"] }}%</div>
</div>
