<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('owner.boats.index') }}" class="flex items-center gap-1.5 text-sm hover:underline" style="color: var(--text-muted);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to My Fleet
        </a>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl">
            <h2 style="font-size: 18px; font-weight: 600; margin: 0 0 24px;">Add New Boat</h2>

            <form method="POST" action="{{ route('owner.boats.store') }}">
                @csrf

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    {{-- Name --}}
                    <div>
                        <label class="label" for="name">Boat Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="input" placeholder="e.g., MV Sea Explorer">
                        @error('name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    {{-- Type --}}
                    <div>
                        <label class="label" for="type">Boat Type</label>
                        <input type="text" id="type" name="type" value="{{ old('type') }}" required class="input" placeholder="e.g., Fishing Boat, Speedboat, Catamaran">
                        @error('type') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    {{-- Capacity --}}
                    <div>
                        <label class="label" for="capacity">Passenger Capacity</label>
                        <input type="number" id="capacity" name="capacity" value="{{ old('capacity', 1) }}" required min="1" class="input">
                        @error('capacity') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    {{-- Location --}}
                    <div>
                        <label class="label" for="location">Location</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}" class="input" placeholder="e.g., Port Dickson, Langkawi">
                        @error('location') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="label" for="description">Description</label>
                        <textarea id="description" name="description" rows="4" class="input" placeholder="Describe your boat, amenities, and what makes it special...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Pricing --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div>
                            <label class="label" for="price_per_hour">Price per Hour (RM)</label>
                            <input type="number" id="price_per_hour" name="price_per_hour" value="{{ old('price_per_hour') }}" min="0" step="0.01" class="input" placeholder="0.00">
                        </div>
                        <div>
                            <label class="label" for="price_per_trip">Price per Trip (RM)</label>
                            <input type="number" id="price_per_trip" name="price_per_trip" value="{{ old('price_per_trip') }}" min="0" step="0.01" class="input" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">Add Boat</button>
                    <a href="{{ route('owner.boats.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
