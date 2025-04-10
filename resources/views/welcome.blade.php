<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Leon's Lab</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="bg-gray-800 text-[#1b1b18] flex items-center lg:justify-center min-h-screen flex-col">
    <header class="w-full text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="p-6 flex items-center justify-end gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="p-[1px] rounded-sm bg-gradient-to-r from-cyan-400 to-rose-500 hover:drop-shadow-[0_0_6px_rgba(255,100,200,0.6)] transition">
                        <div class="px-5 py-1.5 bg-black text-white rounded-sm text-sm leading-normal">
                            Dashboard
                        </div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="p-[1px] rounded-sm bg-gradient-to-r from-cyan-400 to-rose-500 hover:drop-shadow-[0_0_6px_rgba(100,255,255,0.5)] transition">
                        <div class="px-5 py-1.5 bg-black text-white rounded-sm text-sm leading-normal">
                            Log in
                        </div>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="p-[1px] rounded-sm bg-gradient-to-r from-cyan-400 to-rose-500 hover:drop-shadow-[0_0_6px_rgba(255,100,200,0.6)] transition">
                            <div class="px-5 py-1.5 bg-black text-white rounded-sm text-sm leading-normal">
                                Register
                            </div>
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col items-center mt-16">

            <div class="w-full flex flex-col items-center px-4">
                <div class="flex items-center gap-8">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-400 to-rose-500 bg-clip-text text-transparent drop-shadow-[0_0_10px_rgba(100,255,255,0.6)]" style="font-family: 'Press Start 2P', cursive;">
                        LEON'S LAB
                    </h1>
                    <div class="drop-shadow-[0_0_10px_rgba(255,100,200,0.6)]">
                        <x-application-logo />
                    </div>
                </div>
            </div>

            <x-forms.divider/>
            <x-forms.divider/>
            <div class="h-[2px] w-full bg-gradient-to-r from-cyan-400 to-rose-500 drop-shadow-[0_0_6px_rgba(100,255,255,0.7)] mb-1"></div>
            <div class="h-[2px] w-full bg-gradient-to-r from-cyan-400 to-rose-500 drop-shadow-[0_0_6px_rgba(100,255,255,0.7)] mb-1"></div>

            <div class="bg-white w-full">

                <h1 class="p-16 text-center text-4xl">
                    What is Leon's Lab Project?
                </h1>
                <div class="flex flex-col lg:flex-row-reverse items-center gap-6 px-4 py-4 max-w-6xl mx-auto">
                    <img class="w-[600px] lg:w-[700px]" src="{{ Vite::asset('resources/images/welcome/lab-welcome.gif') }}" alt="Welcome 2">
                    <p class="text-sm lg:text-base leading-relaxed text-center lg:text-left">
                        Leon's Lab is a mini-ERP project developed by <strong>JOELdev</strong> for educational purposes. <br>
                        It began as a personal SQL database project back in 2022 and was shared publicly on
                        <a href="https://github.com/JoelHernandezcoder/SQLcourse_Coderhouse.git" target="_blank" class="text-blue-600 underline">GitHub</a>. <br>
                        What started as a simple academic exercise quickly evolved into a software solution designed to help manage business operations with clarity and efficiency. <br><br>
                        <em>Leon’s Lab is available in both English and Spanish for greater accessibility.</em>
                    </p>
                </div>
            </div>

            <div class="h-[2px] w-full bg-gradient-to-r from-cyan-400 to-rose-500 drop-shadow-[0_0_6px_rgba(100,255,255,0.7)] mt-1 mb-1"></div>
            <div class="h-[2px] w-full bg-gradient-to-r from-cyan-400 to-rose-500 drop-shadow-[0_0_6px_rgba(100,255,255,0.7)] mb-1"></div>
            <h1 class="text-white p-16 text-center text-4xl">
                How does it manage employees and inventory?
            </h1>
            <div class="flex flex-col lg:flex-row items-center gap-6 px-4 py-4 max-w-6xl mx-auto">
                <img class="w-[400px] lg:w-[500px]" src="{{ Vite::asset('resources/images/welcome/lab-welcome2.gif') }}" alt="Welcome 3">
                <p class="text-white text-sm lg:text-base leading-relaxed max-w-xl text-center lg:text-left">
                    The platform allows easy registration and management of employees, products, and raw materials.  <br>It simplifies daily operations, helping teams stay organized while maintaining accurate records of all company assets and sales-related data.
                </p>
            </div>

            <x-forms.divider/>
            <div class="h-[2px] w-full bg-gradient-to-r from-cyan-400 to-rose-500 drop-shadow-[0_0_6px_rgba(100,255,255,0.7)] mb-1"></div>
            <div class="h-[2px] w-full bg-gradient-to-r from-cyan-400 to-rose-500 drop-shadow-[0_0_6px_rgba(100,255,255,0.7)] mb-1"></div>

            <div class="bg-white w-full">
                <h1 class="p-16 text-center text-4xl">
                    What is the Production Calendar for?
                </h1>
                <div class="flex flex-col lg:flex-row-reverse items-center gap-6 px-4 py-4 max-w-6xl mx-auto">
                    <img class="w-[750px] lg:w-[850px]" src="{{ Vite::asset('resources/images/welcome/lab-welcome4.gif') }}" alt="Welcome 4">
                    <p class="text-sm lg:text-base leading-relaxed text-center lg:text-left">
                        One of Leon's Lab's most powerful features is its integrated production calendar.  <br>It lets users schedule tasks, monitor deadlines, and keep track of the entire production workflow in a simple and visual way.
                    </p>
                </div>
            </div>

            <div class="h-[2px] w-full bg-gradient-to-r from-cyan-400 to-rose-500 drop-shadow-[0_0_6px_rgba(100,255,255,0.7)] mt-1 mb-1"></div>
            <div class="h-[2px] w-full bg-gradient-to-r from-cyan-400 to-rose-500 drop-shadow-[0_0_6px_rgba(100,255,255,0.7)] mb-1"></div>
            <h1 class="text-white p-16 text-center text-4xl">
                Does it track profits and costs?
            </h1>
            <div class="flex flex-col lg:flex-row items-center gap-6 px-4 py-4 max-w-6xl mx-auto">
                <img class="w-[600px] lg:w-[700px]" src="{{ Vite::asset('resources/images/welcome/lab-welcome3.gif') }}" alt="Welcome 5">
                <p class="text-white text-sm lg:text-base leading-relaxed max-w-xl text-center lg:text-left">
                    The software also includes a financial tracker. It helps calculate profits, monitor expenses, and get a clear overview of operational costs — empowering smarter business decisions backed by real data.
                </p>
            </div>

            <x-forms.divider/>

            <p class="text-gray-500 text-sm text-center mt-8 mb-4">
                © 2025 Leon's Lab. Developed by <strong>JOELdev</strong> as part of an academic and professional initiative. <br>
                Project repository available on
                <a href="https://github.com/JoelHernandezcoder/Laravel_LeonLabs.git" target="_blank" class="underline text-cyan-400 hover:text-rose-400 transition">
                    GitHub
                </a>.
            </p>
        </main>
    </div>

    @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
