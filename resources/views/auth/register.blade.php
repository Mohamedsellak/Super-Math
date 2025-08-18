<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - Edufacilita</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-sky-50 via-indigo-50 to-emerald-50">
        <div class="relative">
            <div class="absolute -top-8 -left-8 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-lg opacity-30 "></div>
            <div class="absolute -top-8 -right-8 w-64 h-64 bg-yellow-300 rounded-full mix-blend-multiply filter blur-lg opacity-30 "></div>
            <div class="absolute -bottom-8 left-20 w-64 h-64 bg-pink-300 rounded-full mix-blend-multiply filter blur-lg opacity-30 "></div>

            <a href="{{ route('welcome') }}" class="group relative flex flex-col items-center transform hover:scale-105 transition duration-300">
                <div class="bg-white/20 group-hover:bg-white/30 backdrop-blur-sm transition duration-300 rounded-2xl p-4 shadow-lg">
                    <svg class="w-12 h-12 text-indigo-600 transform group-hover:rotate-6 transition-all duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
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

        <div class="w-full max-w-2xl mt-8 px-8 py-10 bg-white/90 backdrop-blur-sm shadow-[0_8px_30px_rgb(0,0,0,0.12)] rounded-2xl border border-white/20">
            <div class="space-y-8">
                <div class="text-center space-y-2">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-indigo-800 to-gray-900 bg-clip-text text-transparent">
                        Inscription
                    </h2>
                    <p class="text-sm text-gray-600">
                        Créez votre compte pour accéder à Edufacilita
                    </p>
                </div>


                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">
                                Prénom
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input id="first_name" name="first_name" type="text" autocomplete="given-name" required value="{{ old('first_name') }}"
                                    class="block w-full pl-10 pr-4 py-3 rounded-full border-2 border-gray-200 bg-white/50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all duration-200 hover:border-gray-300 shadow-sm"
                                    placeholder="Votre prénom">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">
                                Nom
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input id="last_name" name="last_name" type="text" autocomplete="family-name" required value="{{ old('last_name') }}"
                                    class="block w-full pl-10 pr-4 py-3 rounded-full border-2 border-gray-200 bg-white/50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all duration-200 hover:border-gray-300 shadow-sm"
                                    placeholder="Votre nom">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                        <div class="space-y-2">
                            <label for="email_confirmation" class="block text-sm font-medium text-gray-700">
                                Confirmer l'adresse email
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input id="email_confirmation" name="email_confirmation" type="email" autocomplete="email" required value="{{ old('email_confirmation') }}"
                                    class="block w-full pl-10 pr-4 py-3 rounded-full border-2 border-gray-200 bg-white/50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all duration-200 hover:border-gray-300 shadow-sm"
                                    placeholder="Confirmez votre email">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Téléphone
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <input id="phone" name="phone" type="tel" autocomplete="tel" required value="{{ old('phone') }}"
                                    class="block w-full pl-10 pr-4 py-3 rounded-full border-2 border-gray-200 bg-white/50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all duration-200 hover:border-gray-300 shadow-sm"
                                    placeholder="+212 6 12 34 56 78">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="institution" class="block text-sm font-medium text-gray-700">
                                Institution <span class="text-gray-400 text-xs">(optionnel)</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <input id="institution" name="institution" type="text" autocomplete="organization" value="{{ old('institution') }}"
                                    class="block w-full pl-10 pr-4 py-3 rounded-full border-2 border-gray-200 bg-white/50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all duration-200 hover:border-gray-300 shadow-sm"
                                    placeholder="Votre institution">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Mot de passe
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                    class="block w-full pl-10 pr-4 py-3 rounded-full border-2 border-gray-200 bg-white/50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all duration-200 hover:border-gray-300 shadow-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Confirmer le mot de passe
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                    class="block w-full pl-10 pr-4 py-3 rounded-full border-2 border-gray-200 bg-white/50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all duration-200 hover:border-gray-300 shadow-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="relative w-full inline-flex items-center justify-center px-8 py-3 overflow-hidden text-sm font-medium text-white transition-all duration-300 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 rounded-full group hover:bg-gradient-to-r focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </span>
                            <span class="relative">S'inscrire</span>
                        </button>
                    </div>
                </form>

                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-6 py-2 bg-white/80 rounded-xl text-gray-600">
                            Vous avez déjà un compte ?
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
