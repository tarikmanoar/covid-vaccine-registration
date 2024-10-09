<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
                @if ($vaccinations->isEmpty())
                <div class="bg-gray-50 flex items-center justify-center">
                    <div class="text-center">
                        <div class="inline-block p-6 rounded-lg border-2 border-gray-200 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-12 h-12 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-2">@lang("No vaccine")</h2>
                        <p class="text-gray-600 mb-6">@lang("Get started by registering a new vaccine.")</p>
                        <a href="{{route('vaccination.create')}}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out">
                            + @lang("Take a vaccine")
                        </a>
                    </div>
                </div>
                @else
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Recent vaccine</h2>

                @foreach ($vaccinations as $doze => $vaccination)
                @php
                    $center = $vaccination->first()->center;
                    $histories = $vaccination->first()->histories;
                @endphp
                <p class=" font-semibold text-gray-800 mb-4">{{$doze}} Doze: at ({{$center->name}}) </p>
                @foreach ($histories as $history)
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0 w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                        <x-dynamic-component :component="'icons.'.strtolower($history->status)" class="h-5 w-5 text-gray-500" />
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-700">
                            {{$history->note}}
                        </p>
                        <p class="text-sm text-gray-500">
                            on <time datetime="{{$history->created_ar}}">{{$history->created_at->format('F d')}}</time>
                        </p>
                    </div>
                </div>
                @endforeach
                @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
