@extends('layouts.app')

@section('content')
    @if(Auth::check())
        <!--{{ Auth::user()->name }}-->
        <div class="col-sm-8">
                @if (count($tasks) > 0)
                    @include('tasks.tasks', ['tasks' => $tasks])
                @endif
        </div>
         {!! link_to_route('tasks.create', '新規タスクの作成', [], ['class' => 'btn btn-primary']) !!}
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasklist</h1>
                {!! link_to_route('signup.get', 'Sign up now!',[], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div
    @endif
@endsection