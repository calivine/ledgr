@if(session('alert'))
    <div class="alert-success">
        <span class="alert-text">{{ session('alert') }}</span>
    </div>
@endif
