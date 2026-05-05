@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Global Dashboard</h1>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        Overview across all verticals
    </p>
</div>

{{-- Vertical Cards --}}
@if(count($verticalStats) > 0)
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3 mb-8">
        @foreach($verticalStats as $slug => $vertical)
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">

                {{-- Header --}}
                <div class="flex items-start justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl"
                              style="background-color: {{ $vertical['color'] }}20">
                            <span class="h-3 w-3 rounded-full"
                                  style="background-color: {{ $vertical['color'] }}"></span>
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                {{ $vertical['name'] }}
                            </h3>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                {{ implode(', ', array_map('ucfirst', $vertical['modules'])) }}
                            </p>
                        </div>
                    </div>

                    {{-- Switch to this vertical --}}
                    <form method="POST" action="{{ route('vertical.switch') }}">
                        @csrf
                        <input type="hidden" name="vertical" value="{{ $slug }}" />
                        <button type="submit"
                            class="inline-flex items-center gap-1 text-sm font-medium text-brand-500 hover:text-brand-600 transition">
                            Open
                            <x-icon name="arrow-right" class="w-4 h-4" />
                        </button>
                    </form>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-xl bg-gray-50 dark:bg-white/[0.03] p-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Leads</p>
                        <p class="text-xl font-semibold text-gray-800 dark:text-white/90">
                            @if($vertical['stats']['leads_total'] !== null)
                                {{ number_format($vertical['stats']['leads_total']) }}
                            @else
                                <span class="text-gray-300 dark:text-gray-600 text-sm">—</span>
                            @endif
                        </p>
                    </div>
                    <div class="rounded-xl bg-gray-50 dark:bg-white/[0.03] p-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Today</p>
                        <p class="text-xl font-semibold text-gray-800 dark:text-white/90">
                            @if($vertical['stats']['leads_today'] !== null)
                                {{ number_format($vertical['stats']['leads_today']) }}
                            @else
                                <span class="text-gray-300 dark:text-gray-600 text-sm">—</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="mt-4 flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <form method="POST" action="{{ route('vertical.switch') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="vertical" value="{{ $slug }}" />
                        <button type="submit"
                            class="w-full rounded-lg bg-brand-500 px-3 py-2 text-xs font-medium text-white hover:bg-brand-600 transition text-center">
                            View Leads
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    {{-- No verticals configured yet --}}
    <div class="rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 p-12 text-center">
        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-gray-400">
                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No verticals configured</h3>
        <p class="text-sm text-gray-400 dark:text-gray-500">
            Add a config file to <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded">config/verticals/</code> to get started.
        </p>
    </div>
@endif

{{-- Quick Actions Bar --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Quick Actions</h3>
    <div class="flex flex-wrap gap-3">
        @foreach($verticalStats as $slug => $vertical)
            <form method="POST" action="{{ route('vertical.switch') }}">
                @csrf
                <input type="hidden" name="vertical" value="{{ $slug }}" />
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                    <span class="h-2 w-2 rounded-full" style="background-color: {{ $vertical['color'] }}"></span>
                    {{ $vertical['name'] }} Leads
                </button>
            </form>
        @endforeach
    </div>
</div>

@endsection
