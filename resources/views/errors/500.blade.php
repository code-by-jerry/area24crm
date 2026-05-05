@extends('layouts.fullscreen-layout')

@section('content')
@php $currentYear = date('Y'); @endphp

<div class="relative flex flex-col items-center justify-center min-h-screen p-6 overflow-hidden z-1">
    <x-common.common-grid-shape />

    <div class="mx-auto w-full max-w-[242px] text-center sm:max-w-[472px]">
        <h1 class="mb-8 font-bold text-gray-800 text-title-md dark:text-white/90 xl:text-title-2xl">
            500
        </h1>

        <p class="mt-6 mb-3 text-xl font-semibold text-gray-800 dark:text-white/90">
            Something went wrong
        </p>
        <p class="mb-8 text-base text-gray-500 dark:text-gray-400">
            We're having trouble on our end. Please try again in a moment.
        </p>

        @auth
            <a href="{{ route('dashboard.global') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Back to Dashboard
            </a>
        @else
            <a href="{{ route('auth.login') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Go to Login
            </a>
        @endauth
    </div>

    <p class="absolute text-sm text-center text-gray-500 -translate-x-1/2 bottom-6 left-1/2 dark:text-gray-400">
        &copy; {{ $currentYear }} — Area24
    </p>
</div>
@endsection
