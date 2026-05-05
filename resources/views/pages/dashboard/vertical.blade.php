@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-8 flex items-start justify-between">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-1">
            <a href="{{ route('dashboard.global') }}" class="hover:text-brand-500 transition">
                Global Dashboard
            </a>
            <span>/</span>
            <span class="text-gray-800 dark:text-white/90">{{ $vertical['name'] }}</span>
        </div>
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">
            {{ $vertical['name'] }}
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Vertical dashboard — stats and quick actions
        </p>
    </div>

    {{-- Vertical colour badge --}}
    <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-800">
        <span class="h-2 w-2 rounded-full" style="background-color: {{ $vertical['color'] }}"></span>
        <span class="text-gray-600 dark:text-gray-300">{{ $vertical['name'] }}</span>
    </span>
</div>

{{-- KPI Cards --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4 mb-8">

    {{-- Total Leads --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Leads</p>
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-50 dark:bg-brand-500/10">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-brand-500">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.75586 5.50098C7.75586 5.08676 8.09165 4.75098 8.50586 4.75098H18.4985C18.9127 4.75098 19.2485 5.08676 19.2485 5.50098L19.2485 15.4956C19.2485 15.9098 18.9127 16.2456 18.4985 16.2456H8.50586C8.09165 16.2456 7.75586 15.9098 7.75586 15.4956V5.50098ZM8.50586 3.25098C7.26322 3.25098 6.25586 4.25834 6.25586 5.50098V6.26318H5.50195C4.25931 6.26318 3.25195 7.27054 3.25195 8.51318V18.4995C3.25195 19.7422 4.25931 20.7495 5.50195 20.7495H15.4883C16.7309 20.7495 17.7383 19.7421 17.7383 18.4995L17.7383 17.7456H18.4985C19.7411 17.7456 20.7485 16.7382 20.7485 15.4956L20.7485 5.50097C20.7485 4.25833 19.7411 3.25098 18.4985 3.25098H8.50586Z" fill="currentColor"/>
                </svg>
            </span>
        </div>
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">
            {{ $leadStats['total'] !== null ? number_format($leadStats['total']) : '—' }}
        </p>
        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">All time</p>
    </div>

    {{-- Today placeholder — will be wired when API supports date filter --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 dark:text-gray-400">Today</p>
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-50 dark:bg-green-500/10">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-green-500">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </span>
        </div>
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">—</p>
        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Coming soon</p>
    </div>

    {{-- Modules count --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 dark:text-gray-400">Modules</p>
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-50 dark:bg-purple-500/10">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-purple-500">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.665 3.75618C11.8762 3.65061 12.1247 3.65061 12.3358 3.75618L18.7807 6.97853L12.3358 10.2009C12.1247 10.3064 11.8762 10.3064 11.665 10.2009L5.22014 6.97853L11.665 3.75618ZM4.29297 8.19199V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0365V11.6512C11.1631 11.6205 11.0777 11.5843 10.9942 11.5425L4.29297 8.19199ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19199L13.0066 11.5425C12.9229 11.5844 12.8372 11.6207 12.75 11.6515V20.037Z" fill="currentColor"/>
                </svg>
            </span>
        </div>
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">
            {{ count($vertical['modules']) }}
        </p>
        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
            {{ implode(', ', array_map('ucfirst', $vertical['modules'])) }}
        </p>
    </div>

    {{-- API Status --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 dark:text-gray-400">API Status</p>
            <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ $leadStats['total'] !== null ? 'bg-green-50 dark:bg-green-500/10' : 'bg-red-50 dark:bg-red-500/10' }}">
                <span class="h-2.5 w-2.5 rounded-full {{ $leadStats['total'] !== null ? 'bg-green-500' : 'bg-red-400' }}"></span>
            </span>
        </div>
        <p class="text-sm font-semibold {{ $leadStats['total'] !== null ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
            {{ $leadStats['total'] !== null ? 'Connected' : 'Unreachable' }}
        </p>
        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500 truncate">
            {{ $vertical['api_base'] }}
        </p>
    </div>

</div>

{{-- Recent Leads + Quick Actions --}}
<div class="grid grid-cols-12 gap-6">

    {{-- Recent Leads --}}
    <div class="col-span-12 xl:col-span-8">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Recent Leads</h3>
                <a href="{{ route('leads.index') }}"
                   class="text-sm text-brand-500 hover:text-brand-600 transition">
                    View all →
                </a>
            </div>

            @if(count($recentLeads) > 0)
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($recentLeads as $lead)
                        <div class="flex items-center justify-between px-6 py-4">
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $lead['name'] }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                    {{ $lead['phone'] ?? '' }}
                                    @if(!empty($lead['email']))
                                        · {{ $lead['email'] }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                @if(!empty($lead['type']))
                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                        {{ ucfirst($lead['type']) }}
                                    </span>
                                @endif
                                <a href="{{ route('leads.show', $lead['id']) }}"
                                   class="text-xs text-brand-500 hover:text-brand-600">
                                    View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <p class="text-sm text-gray-400 dark:text-gray-500">No leads yet.</p>
                    <a href="{{ route('leads.create') }}"
                       class="mt-3 inline-flex items-center gap-1.5 text-sm text-brand-500 hover:text-brand-600">
                        Add the first lead →
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-span-12 xl:col-span-4 space-y-4">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Quick Actions</h4>
            <div class="space-y-2">
                @if(in_array('leads', $vertical['modules']))
                    <a href="{{ route('leads.create') }}"
                       class="flex items-center gap-3 rounded-lg border border-gray-200 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 transition">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-brand-500">
                            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Add New Lead
                    </a>
                    <a href="{{ route('leads.index') }}"
                       class="flex items-center gap-3 rounded-lg border border-gray-200 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 transition">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-gray-400">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5Z" fill="currentColor"/>
                        </svg>
                        All Leads
                    </a>
                @endif

                <a href="{{ route('dashboard.global') }}"
                   class="flex items-center gap-3 rounded-lg border border-gray-200 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 transition">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-gray-400">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5Z" fill="currentColor"/>
                    </svg>
                    Global Dashboard
                </a>
            </div>
        </div>

        {{-- Vertical Info --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Vertical Info</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Slug</span>
                    <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-gray-600 dark:text-gray-300">
                        {{ $vertical['slug'] }}
                    </code>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Modules</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ count($vertical['modules']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 dark:text-gray-400">API</span>
                    <span class="text-xs text-gray-400 dark:text-gray-500 truncate max-w-[140px]" title="{{ $vertical['api_base'] }}">
                        {{ $vertical['api_base'] }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
