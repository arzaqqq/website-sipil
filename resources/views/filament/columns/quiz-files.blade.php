@if(is_array($getState()))
    <ul class="break-all">
        @foreach($getState() as $file)
            <li>{{ $file }}</li>
        @endforeach
    </ul>
@else
    {{ $getState() }}
@endif
