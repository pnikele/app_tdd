{{-- <div class="card" style="height: 200px"> --}}
    
<div class="card" style="min-height: 200px; padding:20px;"> 
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4">
        <a href="{{ $project->path() }}" style="color:black;no-underline">{{ $project->title }}</a>
    </h3>

    <div style="color:gray;margin-bottom:10px">{{ ($project->description)}}</div>

    @can ('manage', $project)
        <footer>
            <form method="POST" action="{{$project->path()}}">
                @method('DELETE')
                @csrf
                <button style="float:right" type="submit">Delete</button>
            </form>
        </footer>
    @endcan

</div>

