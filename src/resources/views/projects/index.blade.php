@extends ('layouts.app')

@section('content')
    <header style="margin-bottom:15px">
        <div style="display:flex">
            <p style="margin-right:auto" >
                    <a style="color:gray" >My Projects</a>
            </p>
            {{-- <a style="margin-left:auto" href="/projects/create" class="button" >New Project</a> --}}
            <new-project-modal></new-project-modal>
        </div>
    </header>

    <div class="flex">
        @forelse ($projects as $project)
        <div >
                @include ('projects.card')
        </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>

@endsection