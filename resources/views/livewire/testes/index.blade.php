<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __($quiz->title) }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="p-6 lg:p-8 bg-white border-b border-gray-200 text-center">
                {{-- <x-application-logo class="block h-12 w-auto" /> --}}

                <h2 class="mt-8 text-3xl font-medium text-gray-900">
                    {!! $quiz->message_before !!}
                </h2>

                {{-- <p class="mt-6 text-gray-500 leading-relaxed">
                    Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application.
                    Laravel is designed
                    to help you build your application using a development environment that is simple, powerful, and
                    enjoyable. We believe
                    you should love expressing your creativity through programming, so we have spent time carefully
                    crafting the Laravel
                    ecosystem to be a breath of fresh air. We hope you love it.
                </p> --}}

                <a href="{{ route('teste-form', ['slug' => $quiz->slug]) }}" class="inline-flex items-center my-4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-lg text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Inciar teste</a>
            </div>
        </div>
    </div>
</div>
