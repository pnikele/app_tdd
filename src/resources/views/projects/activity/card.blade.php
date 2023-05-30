<div class="card mt-3"  style="padding:20px;margin-top:0px;margin-bottom:0px">
    <ul style="font-size:small;margin-bottom:0px;list-style-type: none;padding:0">
        @foreach ($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }}" >
                @include ("projects.activity.{$activity->description}")
                <span style="color:grey">{{ $activity->created_at->diffForHumans(null, true) }}</span>
            </li>
        @endforeach
    </ul>
</div>