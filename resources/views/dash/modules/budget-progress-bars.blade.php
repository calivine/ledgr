@foreach($data as $index => &$row)
    @if($row["planned"] > 0)
        <div class='progress-bars my-3'>
            <p class='progress-bar-label text-left'>{{ $row["category"] }}:</p><p class='progress-bar-label float-right'>${{ $row["actual"] }} of ${{ $row["planned"] }}</p>
            <div class='progress' style='height: 20px;'>
                <div class='progress-bar bg-{{ $row["color"] }} {{ $row["color"] == 'warning' ? 'text-body' : '' }}' role='progressbar' style='width: {{ $row["percent"] }}%' aria-valuenow='{{ $row["actual"] }}' aria-valuemin='0' aria-valuemax='{{ $row["planned"] }}'>{{ $row["percent"] }}%</div>
            </div>
        </div>
    @endif
@endforeach
