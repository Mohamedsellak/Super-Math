<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié - Edufacilita</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-sky-50 via-indigo-50 to-emerald-50">
        <div class="relative">
            <div class="absolute -top-8 -left-8 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-lg opacity-30 "></div>
            <div class="absolute -top-8 -right-8 w-64 h-64 bg-yellow-300 rounded-full mix-blend-multiply filter blur-lg opacity-30 "></div>
            <div class="absolute -bottom-8 left-20 w-64 h-64 bg-pink-300 rounded-full mix-blend-multiply filter blur-lg opacity-30 "></div>

            <a href="{{ route('welcome') }}" class="group relative flex flex-col items-center transform hover:scale-102 transition duration-300">
                <div class="bg-white/20 group-hover:bg-white/30 backdrop-blur-sm transition duration-300 rounded-2xl p-4 shadow-lg">
                    <svg class="w-12 h-12 text-indigo-600 transform group-hover:rotate-6 transition-all duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="flex flex-col items-center mt-4 space-y-1">
                    <span class="text-2xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        Edufacilita
                    </span>
                    <span class="text-sm font-medium text-gray-600">Plateforme d'apprentissage mathématique</span>
                </div>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-8 px-8 py-10 bg-white/90 backdrop-blur-sm shadow-[0_8px_30px_rgb(0,0,0,0.12)] rounded-2xl border border-white/20">
            <div class="space-y-8">
                <div class="text-center space-y-2">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-indigo-800 to-gray-900 bg-clip-text text-transparent">
                        Mot de passe oublié
                    </h2>
                    <p class="text-sm text-gray-600">
                        Entrez votre adresse email pour recevoir un lien de réinitialisation
                    </p>
                </div>


                <form class="space-y-6" action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Adresse email
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                class="block w-full pl-10 pr-4 py-3 rounded-full border-2 border-gray-200 bg-white/50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all duration-200 hover:border-gray-300 shadow-sm"
                                placeholder="vous@exemple.com">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="relative w-full inline-flex items-center justify-center px-8 py-3 overflow-hidden text-sm font-medium text-white transition-all duration-300 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 rounded-full group hover:bg-gradient-to-r focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <span class="relative">Envoyer le lien</span>
                        </button>
                    </div>
                </form>

                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-6 py-2 bg-white/80 rounded-xl text-gray-600">
                            Vous vous souvenez de votre mot de passe ?
                            <a href="{{ route('login') }}" class="ml-1 text-indigo-600 hover:text-indigo-500 font-medium">
                                Se connecter
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Alert Component -->
    <x-alert
        :type="session('success') ? 'success' : (session('error') ? 'error' : '')"
        :message="session('success') ?: session('error')"
    />

</body>
</html>
