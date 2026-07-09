<x-guest-layout>
    <div class="guest-page-title">
        <div class="badge-icon">🛠️</div>
        <h1>Guest Maintenance Report</h1>
        <p>
            Submit a hotel maintenance issue without logging in. The admin and receptionist will receive your report.
        </p>
    </div>

    @if (session('success'))
        <div class="guest-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('guest.report.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="title" :value="__('Problem Title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                          :value="old('title')" required autofocus
                          placeholder="Example: Air conditioner not cooling" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                          :value="old('location')" required
                          placeholder="Example: Room 301, Lobby, Elevator B" />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="urgency" :value="__('Urgency Level')" />
            <select id="urgency" name="urgency"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                <option value="low" @selected(old('urgency') === 'low')>Low</option>
                <option value="medium" @selected(old('urgency', 'medium') === 'medium')>Medium</option>
                <option value="high" @selected(old('urgency') === 'high')>High</option>
                <option value="critical" @selected(old('urgency') === 'critical')>Critical</option>
            </select>
            <x-input-error :messages="$errors->get('urgency')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" rows="4"
                      class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      required placeholder="Describe the issue in detail...">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="image" :value="__('Image (Optional)')" />
            <input id="image" name="image" type="file" accept="image/*"
                   class="block mt-1 w-full text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:border-indigo-500 focus:ring-indigo-500" />
            <p class="mt-1 text-xs text-gray-500">Upload a photo of the issue. JPEG or PNG, maximum 2MB.</p>
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('login') }}" class="guest-secondary-link">
                Back to login
            </a>

            <x-primary-button>
                Submit Report
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
