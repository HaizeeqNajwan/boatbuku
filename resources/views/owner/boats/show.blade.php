<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boat Details: ') . $boat->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $boat->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $boat->type }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Capacity</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $boat->capacity }} persons</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $boat->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Price per Hour</dt>
                            <dd class="mt-1 text-sm text-gray-900">RM {{ $boat->price_per_hour ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Price per Trip</dt>
                            <dd class="mt-1 text-sm text-gray-900">RM {{ $boat->price_per_trip ?? 'N/A' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $boat->description ?? 'None' }}</dd>
                        </div>
                    </dl>
                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('owner.boats.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Back to list
                        </a>
                        <a href="{{ route('owner.boats.edit', $boat) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
