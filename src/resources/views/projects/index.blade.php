@extends ('layouts.app')

@section('content')
    <header class="flex items-center mb-3">
        <div class="flex justify-between items-end w-full">
            <h1 class="mr auto">My Projects</h1>
            <a href="/projects/create" class="button">New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            {{-- <div class="lg:w-1/3 px-3 pb-6">
                @include ('projects.card')
            </div> --}}
            <li>
                <a href="{{$project->path()}}">{{$project->title}}</a>
            </li>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </main>
@endsection