<x-guest-layout>

    <div class=" flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            @if (session('error'))
            <div class= border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">@lang('Whoops!')</strong>
                <span class="block sm:inline">@lang('There were some problems with your input.')</span>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    <li>{{ session('error') }}</li>
                </ul>
            </div>
            @endif
            <form method="get" action="{{ route('search.results') }}">
                <!-- National ID -->
                <div class="mt-4" x-data="{ valid: true }">
                    <x-input-label for="nid" :value="__('NID Number')" />
                    <x-text-input id="nid" class="block mt-1 w-full" type="text" name="nid" :value="old('nid')" required
                        autocomplete="nid" x-mask="99999999999999999"
                        x-on:input="valid = [10, 13, 17].includes($event.target.value.length); console.log($event.target.value.length, valid); if ($event.target.value.length > 17) $event.target.value = $event.target.value.slice(0, 17)" />
                    <em x-show="!valid" x-cloak class="text-red-500 text-sm mt-1">{{ __('National ID number should be
                        10, 13 or
                        17 digits.') }}</em>
                    <x-input-error :messages="$errors->get('nid')" class="mt-2" />
                </div>
                <div class="flex items-center justify-center mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Search') }}
                    </x-primary-button>
                </div>
            </form>

    </div>
</x-guest-layout>
