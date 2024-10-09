<x-app-layout>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">@lang('Whoops!')</strong>
                <span class="block sm:inline">@lang('There were some problems with your input.')</span>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    <li>{{ session('error') }}</li>
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('vaccination.store') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="date" :value="__('Date')" />
                    <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')"
                        required autofocus autocomplete="date" min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}" />
                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                </div>

                <!-- Vacine Center -->
                <div class="mt-4">
                    <x-input-label for="center_id" :value="__('Vaccine Center')" />
                    <select name="center_id" class="block mt-1 w-full" id="center_id">
                        <option value="">@lang('Select a nearest center')</option>
                        @forelse ($centers as $center)
                        <option @selected($center->id == old('center_id')) value="{{ $center->id }}">{{ $center->name }}
                        </option>
                        @empty
                        <option value="">{{ __('No vaccine center available') }}</option>
                        @endforelse
                    </select>

                    <x-input-error :messages="$errors->get('center_id')" class="mt-2" />
                </div>

                <!-- Doze -->
                <div class="mt-4">
                    <x-input-label for="doze" :value="__('Vaccine Doze')" />
                    <select name="doze" class="block mt-1 w-full" id="doze">
                        <option value="">@lang('Select a doze')</option>
                        @forelse (['1st', '2nd', '3rd', '4th'] as $doze)
                        <option @selected($doze == old('doze')) value="{{ $doze }}">{{ $doze }}
                        </option>
                        @empty
                        <option value="">{{ __('No doze available') }}</option>
                        @endforelse
                    </select>

                    <x-input-error :messages="$errors->get('doze')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
