<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add a New Boat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('owner.boats.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Boat Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type')" />
                            <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type')" required />
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="capacity" :value="__('Capacity (persons)')" />
                            <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity')" required min="1" />
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="price_per_hour" :value="__('Price per Hour (RM)')" />
                            <x-text-input id="price_per_hour" class="block mt-1 w-full" type="number" step="0.01" name="price_per_hour" :value="old('price_per_hour')" />
                            <x-input-error :messages="$errors->get('price_per_hour')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="price_per_trip" :value="__('Price per Trip (RM)')" />
                            <x-text-input id="price_per_trip" class="block mt-1 w-full" type="number" step="0.01" name="price_per_trip" :value="old('price_per_trip')" />
                            <x-input-error :messages="$errors->get('price_per_trip')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Boat') }}</x-primary-button>
                            <a href="{{ route('owner.boats.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
