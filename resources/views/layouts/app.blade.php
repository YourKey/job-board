<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-base-200">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header>
                    <div class="container mx-auto max-w-4xl sm:px-6 lg:px-8 py-4">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
