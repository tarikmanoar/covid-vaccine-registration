<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
                @if ($vaccination->isEmpty())
                <div class="bg-gray-50 flex items-center justify-center">
                    <div class="text-center">
                        <div class="inline-block p-6 rounded-lg border-2 border-gray-200 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-2">@lang("No vaccine")</h2>
                        <p class="text-gray-600 mb-6">@lang("Get started by registering a new vaccine.")</p>
                        <a href="{{route('vaccination.create')}}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out">
                            + @lang("Take a vaccine")
                        </a>
                    </div>
                </div>
                @else
                <!-- Application -->
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0 w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-700">Applied to <span class="font-medium text-gray-900">Front End Developer</span></p>
                        <p class="text-sm text-gray-500">Sep 20</p>
                    </div>
                </div>

                <!-- Advanced to phone screening -->
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-700">Advanced to phone screening by <span class="font-medium text-gray-900">Bethany Blake</span></p>
                        <p class="text-sm text-gray-500">Sep 22</p>
                    </div>
                </div>

                <!-- Completed phone screening -->
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-700">Completed phone screening with <span class="font-medium text-gray-900">Martha Gardner</span></p>
                        <p class="text-sm text-gray-500">Sep 28</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
