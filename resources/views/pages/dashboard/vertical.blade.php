@extends('layouts.app')

@php
    $statuses     = $vertical['lead_statuses'] ?? [];
    $apiConnected = $leadStats['total'] !== null;

    $statusStyles = [
        'pending'   => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400',
        'contacted' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
        'converted' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400',
        'rejected'  => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400',
    ];
@endphp

@section('content')

{{-- Page Header --}}
<div class="mb-6 flex items-start justify-between">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-1">
            <a href="{{ route('dashboard.global') }}" class="hover:text-brand-500 transition">Global Dashboard</a>
            <span>/</span>
            <span class="text-gray-800 dark:text-white/90">{{ $vertical['name'] }}</span>
        </div>
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $vertical['name'] }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Dashboard overview</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-medium
            {{ $apiConnected ? 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400' : 'bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400' }}">
            <span class="h-1.5 w-1.5 rounded-full {{ $apiConnected ? 'bg-green-500' : 'bg-red-400' }}"></span>
            {{ $apiConnected ? 'API Connected' : 'API Unreachable' }}
        </span>
        <a href="{{ route('leads.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition">
            <x-icon name="plus" class="w-4 h-4" />
            Add Lead
        </a>
    </div>
</div>

{{-- ── Row 1: KPI Metric Cards ─────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">

    {{-- Total Leads --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800 mb-5">
            <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549Z" fill=""/>
            </svg>
        </div>
        <div class="flex items-end justify-between">
            <div>
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Leads</span>
                <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                    {{ $leadStats['total'] !== null ? number_format($leadStats['total']) : '—' }}
                </h4>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-brand-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                All time
            </span>
        </div>
    </div>

    {{-- Converted --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-center w-12 h-12 bg-green-50 rounded-xl dark:bg-green-500/10 mb-5">
            <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.70186 12.0001C3.70186 7.41711 7.41711 3.70186 12.0001 3.70186C16.5831 3.70186 20.2984 7.41711 20.2984 12.0001C20.2984 16.5831 16.5831 20.2984 12.0001 20.2984C7.41711 20.2984 3.70186 16.5831 3.70186 12.0001ZM12.0001 1.90186C6.423 1.90186 1.90186 6.423 1.90186 12.0001C1.90186 17.5772 6.423 22.0984 12.0001 22.0984C17.5772 22.0984 22.0984 17.5772 22.0984 12.0001C22.0984 6.423 17.5772 1.90186 12.0001 1.90186ZM15.6197 10.7395C15.9712 10.388 15.9712 9.81819 15.6197 9.46672C15.2683 9.11525 14.6984 9.11525 14.347 9.46672L11.1894 12.6243L9.6533 11.0883C9.30183 10.7368 8.73198 10.7368 8.38051 11.0883C8.02904 11.4397 8.02904 12.0096 8.38051 12.3611L10.553 14.5335C10.7217 14.7023 10.9507 14.7971 11.1894 14.7971C11.428 14.7971 11.657 14.7023 11.8257 14.5335L15.6197 10.7395Z" fill=""/>
            </svg>
        </div>
        <div class="flex items-end justify-between">
            <div>
                <span class="text-sm text-gray-500 dark:text-gray-400">Converted</span>
                <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                    {{ number_format($leadStats['converted'] ?? 0) }}
                </h4>
            </div>
            @if(($leadStats['total'] ?? 0) > 0)
                <span class="flex items-center gap-1 rounded-full bg-green-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-green-600 dark:bg-green-500/15 dark:text-green-400">
                    {{ round((($leadStats['converted'] ?? 0) / $leadStats['total']) * 100, 1) }}%
                </span>
            @endif
        </div>
    </div>

    {{-- Pending --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-center w-12 h-12 bg-yellow-50 rounded-xl dark:bg-yellow-500/10 mb-5">
            <svg class="fill-yellow-600 dark:fill-yellow-400" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.6501 11.9996C3.6501 7.38803 7.38852 3.64961 12.0001 3.64961C16.6117 3.64961 20.3501 7.38803 20.3501 11.9996C20.3501 16.6112 16.6117 20.3496 12.0001 20.3496C7.38852 20.3496 3.6501 16.6112 3.6501 11.9996ZM12.0001 1.84961C6.39441 1.84961 1.8501 6.39392 1.8501 11.9996C1.8501 17.6053 6.39441 22.1496 12.0001 22.1496C17.6058 22.1496 22.1501 17.6053 22.1501 11.9996C22.1501 6.39392 17.6058 1.84961 12.0001 1.84961ZM10.9992 7.52468C10.9992 8.07697 11.4469 8.52468 11.9992 8.52468H12.0002C12.5525 8.52468 13.0002 8.07697 13.0002 7.52468C13.0002 6.9724 12.5525 6.52468 12.0002 6.52468H11.9992C11.4469 6.52468 10.9992 6.9724 10.9992 7.52468ZM12.0002 17.371C11.586 17.371 11.2502 17.0352 11.2502 16.621V10.9445C11.2502 10.5303 11.586 10.1945 12.0002 10.1945C12.4144 10.1945 12.7502 10.5303 12.7502 10.9445V16.621C12.7502 17.0352 12.4144 17.371 12.0002 17.371Z" fill=""/>
            </svg>
        </div>
        <div class="flex items-end justify-between">
            <div>
                <span class="text-sm text-gray-500 dark:text-gray-400">Pending</span>
                <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                    {{ number_format($leadStats['pending'] ?? 0) }}
                </h4>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-yellow-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400">
                Open
            </span>
        </div>
    </div>

    {{-- Contacted --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-center w-12 h-12 bg-blue-50 rounded-xl dark:bg-blue-500/10 mb-5">
            <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.00002 12.0957C4.00002 7.67742 7.58174 4.0957 12 4.0957C16.4183 4.0957 20 7.67742 20 12.0957C20 16.514 16.4183 20.0957 12 20.0957H5.06068L6.34317 18.8132C6.48382 18.6726 6.56284 18.4818 6.56284 18.2829C6.56284 18.084 6.48382 17.8932 6.34317 17.7526C4.89463 16.304 4.00002 14.305 4.00002 12.0957ZM12 2.5957C6.75332 2.5957 2.50002 6.849 2.50002 12.0957C2.50002 14.4488 3.35633 16.603 4.77303 18.262L2.71969 20.3154C2.50519 20.5299 2.44103 20.8525 2.55711 21.1327C2.6732 21.413 2.94668 21.5957 3.25002 21.5957H12C17.2467 21.5957 21.5 17.3424 21.5 12.0957C21.5 6.849 17.2467 2.5957 12 2.5957Z" fill=""/>
            </svg>
        </div>
        <div class="flex items-end justify-between">
            <div>
                <span class="text-sm text-gray-500 dark:text-gray-400">Contacted</span>
                <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                    {{ number_format($leadStats['contacted'] ?? 0) }}
                </h4>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-blue-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                In progress
            </span>
        </div>
    </div>

</div>

{{-- ── Row 2: Charts ────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-12 gap-4 md:gap-6 mb-6">

    {{-- Leads by Type — Bar Chart --}}
    <div class="col-span-12 xl:col-span-7">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 sm:px-6 sm:pt-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Leads by Type</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Breakdown of lead categories</p>
                </div>
            </div>
            <div class="max-w-full overflow-x-auto">
                <div id="leadsTypeChart" class="min-h-[280px]"></div>
            </div>
        </div>
    </div>

    {{-- Status Breakdown — Donut Chart --}}
    <div class="col-span-12 xl:col-span-5">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 sm:px-6 sm:pt-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Status Breakdown</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lead pipeline overview</p>
                </div>
            </div>
            <div id="statusDonutChart" class="min-h-[280px] flex items-center justify-center"></div>

            {{-- Legend --}}
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 pb-5">
                @foreach($statusChartData as $item)
                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ $item['color'] }}"></span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $item['label'] }} ({{ $item['value'] }})</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- ── Row 3: Recent Leads Table ────────────────────────────────────────────── --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Recent Leads</h3>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Latest incoming leads</p>
        </div>
        <a href="{{ route('leads.index') }}"
           class="text-sm font-medium text-brand-500 hover:text-brand-600 transition">
            View all →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Lead</th>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Contact</th>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($recentLeads as $lead)
                    @php $status = $lead['status'] ?? 'pending'; @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-500/10 text-sm font-semibold text-brand-600 dark:text-brand-400 flex-shrink-0">
                                    {{ strtoupper(substr($lead['name'], 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-white/90">{{ $lead['name'] }}</p>
                                    @if(!empty($lead['plotsize']))
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $lead['plotsize'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-700 dark:text-gray-300">{{ $lead['phone'] ?? '—' }}</p>
                            @if(!empty($lead['email']))
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $lead['email'] }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if(!empty($lead['type']))
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                    {{ ucfirst($lead['type']) }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusStyles[$status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $statuses[$status]['label'] ?? ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 dark:text-gray-500">
                            {{ isset($lead['created_at']) ? \Carbon\Carbon::parse($lead['created_at'])->format('d M Y') : '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('leads.show', $lead['id']) }}"
                               class="text-xs font-medium text-brand-500 hover:text-brand-600">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <p class="text-sm text-gray-400 dark:text-gray-500">No leads yet.</p>
                            <a href="{{ route('leads.create') }}"
                               class="mt-2 inline-flex items-center gap-1 text-sm text-brand-500 hover:text-brand-600">
                                Add the first lead →
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Leads by Type — Bar Chart ─────────────────────────────────────────────
    const typeLabels = @json($typeLabels);
    const typeValues = @json($typeValues);

    if (typeLabels.length > 0 && document.getElementById('leadsTypeChart')) {
        const isDark = document.documentElement.classList.contains('dark');

        const barOptions = {
            series: [{ name: 'Leads', data: typeValues }],
            chart: {
                type: 'bar',
                height: 280,
                toolbar: { show: false },
                background: 'transparent',
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            colors: ['#465fff', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'],
            dataLabels: { enabled: false },
            xaxis: {
                categories: typeLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                labels: {
                    style: { colors: isDark ? '#9ca3af' : '#6b7280', fontSize: '13px' }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    style: { colors: isDark ? '#9ca3af' : '#6b7280', fontSize: '12px' }
                }
            },
            grid: {
                borderColor: isDark ? '#1f2937' : '#f3f4f6',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } },
                xaxis: { lines: { show: false } },
            },
            legend: { show: false },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: { formatter: val => val + ' leads' }
            },
        };

        new ApexCharts(document.getElementById('leadsTypeChart'), barOptions).render();
    } else if (document.getElementById('leadsTypeChart')) {
        document.getElementById('leadsTypeChart').innerHTML =
            '<div class="flex items-center justify-center h-[280px] text-sm text-gray-400">No lead type data yet</div>';
    }

    // ── Status Breakdown — Donut Chart ────────────────────────────────────────
    const statusData = @json($statusChartData);
    const hasStatusData = statusData.some(s => s.value > 0);

    if (hasStatusData && document.getElementById('statusDonutChart')) {
        const isDark = document.documentElement.classList.contains('dark');

        const donutOptions = {
            series: statusData.map(s => s.value),
            labels: statusData.map(s => s.label),
            colors: statusData.map(s => s.color),
            chart: {
                type: 'donut',
                height: 280,
                background: 'transparent',
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '13px',
                                color: isDark ? '#9ca3af' : '#6b7280',
                                formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0),
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { show: false },
            stroke: { width: 0 },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: { formatter: val => val + ' leads' }
            },
        };

        new ApexCharts(document.getElementById('statusDonutChart'), donutOptions).render();
    } else if (document.getElementById('statusDonutChart')) {
        document.getElementById('statusDonutChart').innerHTML =
            '<div class="flex items-center justify-center h-[280px] text-sm text-gray-400">No status data yet</div>';
    }

});
</script>
@endpush
