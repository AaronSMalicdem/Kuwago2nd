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
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}

        </div>
        <footer class="py-3 fixed bottom-0 w-full">
            <div class="container mx-auto px-4">
              <div class="flex flex-wrap items-center md:justify-between justify-center">
                <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                  <div class="text-sm text-gray-500 font-semibold py-1">
                    <div>
                          Arzatechnologies. All rights reserved.
                    </div>
                    <div>
                        Copyright © 2021
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </footer>
    </body>
    <!-- Scripts -->
    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
    {{ $script ?? null }}
</html>
