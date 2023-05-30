@if ($errors->{ $bag ?? 'default' }->any())
    <ul class="field mt-6 list-reset">
        @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
            <li style="color:red; font-size:small;">{{ $error }}</li>
        @endforeach
    </ul>
@endif
