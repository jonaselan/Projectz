@extends ('layouts.app')

@section('content')
    <header class="flex items-center mb-3 pb-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-sm font-normal">
                <a href="{!! route('projects.index') !!}" class="text-grey text-sm font-normal no-underline hover:underline">My Projects</a>
                / {{ $project->title }}
            </p>

            {{--<a href="{!! route('projects.edit', $project) !!}" class="button">Edit Project</a>--}}
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>

                    {{-- tasks --}}
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{!! route('projects.tasks.update', [$project, $task]) !!}">
                                @method('PATCH')
                                @csrf

                                <div class="flex items-center">
                                    <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                                    <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{!! route('projects.tasks.store', $project) !!}" method="POST">
                            @csrf

                            <input placeholder="Add a new task..." class="w-full" name="body">
                        </form>
                    </div>
                </div>

                {{--<div>--}}
                    {{--<h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>--}}

                    {{-- general notes --}}
                    {{--<form method="POST" action="{!! route('project.store') !!} }}">--}}
                        {{--@csrf--}}
                        {{--@method('PATCH')--}}

                        {{--<textarea--}}
                            {{--name="notes"--}}
                            {{--class="card w-full mb-4"--}}
                            {{--style="min-height: 200px"--}}
                            {{--placeholder="Anything special that you want to make a note of?"--}}
                        {{-->{{ $project->notes }}</textarea>--}}

                        {{--<button type="submit" class="button">Save</button>--}}
                    {{--</form>--}}

                    {{--@include ('errors')--}}
                {{--</div>--}}
            </div>

            <div class="lg:w-1/4 px-3 lg:py-8">
                @include ('projects.card')
                {{--@include ('projects.activity.card')--}}
            </div>
        </div>
    </main>
@endsection
