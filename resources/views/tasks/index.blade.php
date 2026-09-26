@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-0">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">My Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create New Task
        </a>
    </div>

    @if($tasks->isEmpty())
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <p class="text-gray-500 text-lg">No tasks yet. Create your first task to get started!</p>
        </div>
    @else
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach($tasks as $task)
                    <li class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1">
                                <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="mr-4">
                                    @csrf
                                    <button type="submit" class="focus:outline-none">
                                        @if($task->is_completed)
                                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold {{ $task->is_completed ? 'line-through text-gray-500' : 'text-gray-900' }}">
                                        {{ $task->title }}
                                    </h3>
                                    @if($task->description)
                                        <p class="text-sm text-gray-600 mt-1 {{ $task->is_completed ? 'line-through' : '' }}">
                                            {{ $task->description }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">
                                        Created {{ $task->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex space-x-2 ml-4">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
