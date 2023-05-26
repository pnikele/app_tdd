@extends ('layouts.app')
@section('content')
<header>
        <div style="display:flex">
                <p style="margin-right:auto" >
                        <a style="text-decoration:none;color:gray" href="/projects">My Projects</a> / {{$project->title}}
                     </p>
                <a style="margin-left:auto" href="/projects/create" class="button">New Project</a>

        </div>
</header>
<main>
        <div style="display:flex;padding: -5px;">
                <div class="flex1">
                        <div style="margin-bottom:20px">
                                <h2 style="margin-bottom:3px" class="mr auto">Tasks</h2>
                                @foreach($project->tasks as $task)
                                <div class="card mb-3">
                                <form method="POST" action="{{ $task->path() }}"> 
                                        @method('PATCH')
                                        @csrf
                                        <div style="display:flex">
                                        <input name="body" value="{{ $task->body }}" style="width:100%;border:none; {{ $task->completed ? 'color:gray' : '' }}">
                                        <input name="completed" type="checkbox" style="border:none" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                        </div>
                                </form>
                                </div>
                                @endforeach
                                <div class="card mb-3">
                                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                                            @csrf
                
                                            <input placeholder="Add a new task..." name="body" style="width:100%;border:none">
                                        </form>
                                </div>
                        </div>
                        <div>
                                <h2 style="margin-bottom:3px"class="mr auto">Notes</h2>
                                <form action="{{ $project->path()}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <textarea
                                                name="notes" 
                                                class="card" 
                                                style="text-decoration:none;min-height: 200px;width:100%;margin-bottom:10px" 
                                                placeholder="Want to make a note?"
                                        >{{$project->notes}}</textarea>
                                        <button type="submit">Save</button>
                                </form>
                        </div>
                </div>

        
        <div class="flex2">
                <div class="card" style="min-height: 200px"> 
                        <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-light pl-4">
                            <a class="text-black no-underline">{{ $project->title }}</a>
                        </h3>
                    
                        <div class="text-grey">{{ ($project->description)}}</div>
                    
                    </div>
        </div>
        </div>
</main>

@endsection