<div class="card" style="min-height: 200px; padding:20px; margin-top:1rem"> 
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4">
            Invite a user
    </h3>         
    <form method="POST" action="{{$project->path() . '/invitations'}}">
    @csrf
    <input type="email" name="email" style="margin-bottom:10px" placeholder="Email address">
    <button style="float:right" type="submit">Invite</button>
    </form>
    @include ('errors', ['bag' =>'invitations'])
</div>