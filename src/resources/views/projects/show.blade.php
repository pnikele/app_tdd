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
                        <div class="card">LOrem ipsum</div>
                </div>
                <div>
                        <h2 style="margin-bottom:3px"class="mr auto">Notes</h2>
                        <textarea class="card" style="text-decoration:none;min-height: 200px;width:100%">LOrem ipsum</textarea>
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
</main>

@endsection