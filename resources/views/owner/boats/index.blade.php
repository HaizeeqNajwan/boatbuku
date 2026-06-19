<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Boats') }}
            </h2>
            <a href="{{ route('owner.boats.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Add Boat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($boats->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($boats as $boat)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <h4 class="text-lg font-bold">{{ $boat->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $boat->type }} · Capacity: {{ $boat->capacity }}</p>
                                    <p class="text-sm">
                                        @if($boat->price_per_hour)
                                            RM {{ $boat->price_per_hour }}/hr
                                        @endif
                                        @if($boat->price_per_trip)
                                            RM {{ $boat->price_per_trip }}/trip
                                        @endif
                                    </p>
                                    <div class="mt-3 flex space-x-2">
                                        <a href="{{ route('owner.boats.show', $boat) }}" class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View
                                        </a>
                                        <a href="{{ route('owner.boats.edit', $boat) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            Edit
                                        </a>
                                        <form action="{{ route('owner.boats.destroy', $boat) }}" method="POST" onsubmit="return confirm('Delete this boat?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">You haven't added any boats yet. <a href="{{ route('owner.boats.create') }}" class="text-blue-600 hover:underline">Add one now</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
