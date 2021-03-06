<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @if (auth()->user()->trial_ends_at)
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-lg bg-indigo-100">
                        You have {{ now()->diffInDays(auth()->user()->trial_ends_at) }} days of free trial left.
                        <a class="text-indigo-500" href="{{ route('billings.index') }}">Choose your plan</a> at any time.
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @if (isset($stripeScripts))
            {{ $stripeScripts }}
        @endif

        @if (isset($customScripts))
            {{ $customScripts }}
        @endif

        @livewireScripts
    </body>
</html>
