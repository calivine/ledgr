@foreach($budget as $row)
    @if($row->planned > 0)
        <div class='my-3'>
            <p class='progress-bar-label text-left'>{{ $row->category }}:</p><p class='progress-bar-label float-right'>${{ $row->actual }} of ${{ $row->planned }}</p>
            <div class='progress' style='height: 20px;'>
                <div class='progress-bar {{ $row->actual < $row->planned ? 'bg-success' : 'bg-danger' }}' role='progressbar' style='width: {{ ($row->actual / $row->planned) * 100 }}%' aria-valuenow='{{ $row->actual }}' aria-valuemin='0' aria-valuemax='{{ $row->planned }}'>{{ round(($row->actual / $row->planned) * 100) }}%</div>
            </div>
        </div>
    @endif
@endforeach