<p class='progress-bar-label text-left' style='font-size: 20px'>Total Spending:</p><p class='progress-bar-label float-right' id='bar-label-right' style='font-size: 20px'>${{ round($data["actual"]) }}{{ $data["planned"] == 0 ? '' : ' of $' . $data["planned"] }}</p>
<div class='progress' style='height: 40px; font-size: 20px'>
    <div id='total-spending-bar' class='progress-bar bg-{{ $data["color"] }} {{ $data["color"] == 'warning' ? 'text-body' : '' }}' role='progressbar' style='width: {{ $data["percent"] }}%' aria-valuenow='{{ $data["actual"] }}' aria-valuemin='0' aria-valuemax='{{ $data["planned"] }}'>{{ $data["percent"] }}%</div>
</div>
