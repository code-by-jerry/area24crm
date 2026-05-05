@extends('layouts.fullscreen-layout')

@section('content')
    <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
        <div class="flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">

            <!-- Form Side -->
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto w-full max-w-md pt-5 sm:py-10">
                    <a href="{{ route('dashboard.global') }}"
                        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg class="stroke-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Back to dashboard
                    </a>
                </div>

                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                    <div class="mb-5 sm:mb-8">
                        <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                            Create Account
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Fill in the details below to get started.
                        </p>
                    </div>

                    {{-- Validation errors --}}
                    @if($errors->any())
                        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 dark:border-red-500/30 dark:bg-red-500/10">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm text-red-600 dark:text-red-400">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.register.store') }}">
                        @csrf
                        <div class="space-y-5">

                            {{-- Name --}}
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Your full name"
                                    autocomplete="name"
                                    class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('name') ? 'border-red-400 dark:border-red-500' : 'border-gray-300 dark:border-gray-700' }}" />
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                    class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('email') ? 'border-red-400 dark:border-red-500' : 'border-gray-300 dark:border-gray-700' }}" />
                            </div>

                            {{-- Password --}}
                            <div>
                                <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div x-data="{ show: false }" class="relative">
                                    <input :type="show ? 'text' : 'password'"
                                        id="password" name="password"
                                        placeholder="Min. 8 characters"
                                        autocomplete="new-password"
                                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    <button type="button" @click="show = !show"
                                        class="absolute top-1/2 right-4 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg x-show="!show" width="20" height="20" viewBox="0 0 20 20" fill="none" class="fill-current"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z" fill="#98A2B3"/></svg>
                                        <svg x-show="show" width="20" height="20" viewBox="0 0 20 20" fill="none" class="fill-current"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709Z" fill="#98A2B3"/></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Repeat your password"
                                    autocomplete="new-password"
                                    class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition">
                                Create Account
                            </button>
                        </div>
                    </form>

                    <div class="mt-5">
                        <p class="text-center text-sm text-gray-700 sm:text-start dark:text-gray-400">
                            Already have an account?
                            <a href="{{ route('auth.login') }}" class="text-brand-500 hover:text-brand-600 dark:text-brand-400">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Brand Side -->
            <div class="bg-brand-950 relative hidden h-full w-full items-center lg:grid lg:w-1/2 dark:bg-white/5">
                <div class="z-1 flex items-center justify-center">
                    <x-common.common-grid-shape />
                    <div class="flex max-w-xs flex-col items-center">
                        <a href="/" class="mb-4 block">
                            <img src="/images/logo/auth-logo.svg" alt="Logo" />
                        </a>
                        <p class="text-center text-gray-400 dark:text-white/60">
                            Area24 — Multi-Vertical CRM Dashboard
                        </p>
                    </div>
                </div>
            </div>

            <!-- Theme Toggle -->
            <div class="fixed right-6 bottom-6 z-50">
                <button class="bg-brand-500 hover:bg-brand-600 inline-flex size-14 items-center justify-center rounded-full text-white transition-colors"
                    @click.prevent="$store.theme.toggle()">
                    <svg class="hidden fill-current dark:block" width="20" height="20" viewBox="0 0 20 20"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415Z" fill="currentColor"/></svg>
                    <svg class="fill-current dark:hidden" width="20" height="20" viewBox="0 0 20 20"><path d="M17.4547 11.97C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L17.4547 11.97Z" fill="currentColor"/></svg>
                </button>
            </div>
        </div>
    </div>
@endsection
