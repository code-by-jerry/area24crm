@extends('layouts.app')

@php
    // Status badge styling map
    $statusStyles = [
        'pending'   => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400',
        'contacted' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
        'converted' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400',
        'rejected'  => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400',
    ];
    $statuses = $vertical['lead_statuses'] ?? [];
@endphp

@section('content')

{{-- Page Header --}}
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Leads</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $vertical['name'] }} — all incoming leads
        </p>
    </div>
    <a href="{{ route('leads.create') }}"
       class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-brand-600 transition">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Add Lead
    </a>
</div>

{{-- API Error --}}
@if($error)
    <x-ui.alert variant="error" title="Could not load leads" :message="$error" class="mb-6" />
@endif

{{-- Success Flash --}}
@if(session('success'))
    <x-ui.alert variant="success" :message="session('success')" class="mb-6" />
@endif

{{-- Filters --}}
<div class="mb-4">
    <form method="GET" class="flex flex-wrap items-center gap-3">

        {{-- Type filter --}}
        <select name="type"
            class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
            <option value="">All Types</option>
            @foreach(['residential','commercial','industrial','renovation'] as $t)
                <option value="{{ $t }}" @selected(($filters['type'] ?? '') === $t)>
                    {{ ucfirst($t) }}
                </option>
            @endforeach
        </select>

        {{-- Status filter --}}
        <select name="status"
            class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
            <option value="">All Statuses</option>
            @foreach($statuses as $key => $meta)
                <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>
                    {{ $meta['label'] }}
                </option>
            @endforeach
        </select>

        <button type="submit"
            class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
            Filter
        </button>

        @if(!empty(array_filter($filters)))
            <a href="{{ route('leads.index') }}"
               class="rounded-lg px-4 py-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400">
                Clear
            </a>
        @endif

        {{-- Active filter pills --}}
        @if(!empty($filters['status']))
            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                Status: {{ ucfirst($filters['status']) }}
            </span>
        @endif
        @if(!empty($filters['type']))
            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                Type: {{ ucfirst($filters['type']) }}
            </span>
        @endif

    </form>
</div>

{{-- Leads Table --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">#</th>
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Name</th>
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Phone</th>
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Email</th>
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Type</th>
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Source</th>
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Date</th>
                    <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($leads as $lead)
                    @php $status = $lead['status'] ?? 'pending'; @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition">
                        <td class="px-5 py-4 text-gray-400 dark:text-gray-500">{{ $lead['id'] }}</td>
                        <td class="px-5 py-4 font-medium text-gray-800 dark:text-white/90">
                            {{ $lead['name'] }}
                        </td>
                        <td class="px-5 py-4 text-gray-600 dark:text-gray-300">{{ $lead['phone'] ?? '—' }}</td>
                        <td class="px-5 py-4 text-gray-600 dark:text-gray-300">{{ $lead['email'] ?? '—' }}</td>
                        <td class="px-5 py-4">
                            @if(!empty($lead['type']))
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                    {{ ucfirst($lead['type']) }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if(!empty($lead['status']))
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusStyles[$status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $statuses[$status]['label'] ?? ucfirst($status) }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusStyles['pending'] }}">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 dark:text-gray-400 text-xs">
                            {{ $lead['source'] ?? '—' }}
                        </td>
                        <td class="px-5 py-4 text-gray-500 dark:text-gray-400 text-xs">
                            {{ isset($lead['created_at']) ? \Carbon\Carbon::parse($lead['created_at'])->format('d M Y') : '—' }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('leads.show', $lead['id']) }}"
                                   class="text-brand-500 hover:text-brand-600 text-xs font-medium">
                                    View
                                </a>
                                <form method="POST"
                                      action="{{ route('leads.destroy', $lead['id']) }}"
                                      onsubmit="return confirm('Delete this lead?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-600 text-xs font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-5 py-12 text-center text-gray-400 dark:text-gray-500">
                            No leads found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(!empty($meta['last_page']) && $meta['last_page'] > 1)
        <div class="flex items-center justify-between border-t border-gray-100 px-5 py-4 dark:border-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Showing {{ $meta['from'] ?? 1 }}–{{ $meta['to'] ?? count($leads) }}
                of {{ $meta['total'] ?? count($leads) }} leads
            </p>
            <div class="flex gap-2">
                @if(!empty($links['prev']))
                    <a href="{{ $links['prev'] }}"
                       class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                        Previous
                    </a>
                @endif
                @if(!empty($links['next']))
                    <a href="{{ $links['next'] }}"
                       class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                        Next
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

@endsection
