<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full flex flex-col items-center justify-center">
                <div class="text-center">
                    <div class="my-5">
                        <h2 class="text-2xl font-bold text-gray-900">Search Results</h2>
                        <p class="text-gray-500">Search results for "{{ request('nid') }}"</p>
                        <p>{{$user->name}} Details</p>
                    </div>
                    @for ($i = 0; $i < 4; $i++)
                        @php
                        $vaccine=isset($vaccinations[$i]) ? $vaccinations[$i] : null;
                        @endphp
                    <div
                        class="my-5 p-4 border rounded-lg shadow-sm {{ $vaccine ? 'bg-green-50' : 'bg-red-50' }}">
                        <h3 class="text-lg font-semibold text-gray-700">Vaccination {{$i+1}}</h3>
                        @if ($vaccine)
                        <p class="text-gray-600"><span class="font-medium">Date:</span> {{ $vaccine->date->format('M d,
                            Y') }}</p>
                        <p class="text-gray-600"><span class="font-medium">Center:</span> {{ $vaccine->center->name }}
                        </p>
                        <p class="text-gray-600"><span class="font-medium">Dose:</span> {{ $vaccine->doze }}</p>
                        <p class="text-gray-600"><span class="font-medium">Status:</span> {{ $vaccine->status }}</p>
                        @else
                        <p class="text-gray-600">No data available</p>
                        @endif
                    </div>
                    @endfor
                </div>
                <div class="text-center py-5">
                    <a href="{{ route('search.index') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search
                        Again</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
