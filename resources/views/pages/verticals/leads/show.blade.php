@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
        <a href="{{ route('leads.index') }}"
           class="hover:text-brand-500 transition">Leads</a>
        <span>/</span>
        <span class="text-gray-800 dark:text-white/90">#{{ $lead['id'] }}</span>
    </div>
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $lead['name'] }}</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $vertical['name'] }}</p>
        </div>
        <form method="POST"
              action="{{ route('leads.destroy', $lead['id']) }}"
              onsubmit="return confirm('Delete this lead permanently?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg border border-red-200 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:border-red-500/30 dark:text-red-400 dark:hover:bg-red-500/10 transition">
                Delete Lead
            </button>
        </form>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <x-ui.alert variant="success" :message="session('success')" class="mb-6" />
@endif

@if($errors->any())
    <x-ui.alert variant="error" title="Could not update lead" class="mb-6">
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.alert>
@endif

<div class="grid grid-cols-12 gap-6">

    {{-- Lead Info Card --}}
    <div class="col-span-12 xl:col-span-8">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Lead Information</h3>
                <span class="text-xs text-gray-400 dark:text-gray-500">
                    ID #{{ $lead['id'] }}
                </span>
            </div>

            <form method="POST"
                  action="{{ route('leads.update', $lead['id']) }}"
                  class="p-6 space-y-5">
                @csrf
                @method('PUT')

                @foreach($vertical['lead_fields'] as $field)
                    <div>
                        <label for="{{ $field['key'] }}"
                               class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $field['label'] }}
                        </label>

                        @if($field['type'] === 'select')
                            <select id="{{ $field['key'] }}"
                                    name="{{ $field['key'] }}"
                                    class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                <option value="">— Select —</option>
                                @foreach($field['options'] as $option)
                                    <option value="{{ $option }}"
                                        @selected(($lead[$field['key']] ?? '') === $option)>
                                        {{ ucfirst($option) }}
                                    </option>
                                @endforeach
                            </select>

                        @elseif($field['type'] === 'textarea')
                            <textarea id="{{ $field['key'] }}"
                                      name="{{ $field['key'] }}"
                                      rows="4"
                                      class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 resize-none">{{ old($field['key'], $lead[$field['key']] ?? '') }}</textarea>

                        @else
                            <input id="{{ $field['key'] }}"
                                   type="{{ $field['type'] }}"
                                   name="{{ $field['key'] }}"
                                   value="{{ old($field['key'], $lead[$field['key']] ?? '') }}"
                                   class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300" />
                        @endif
                    </div>
                @endforeach

                <div class="pt-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Meta Sidebar --}}
    <div class="col-span-12 xl:col-span-4 space-y-4">

        {{-- Status Quick-Change --}}
        @php
            $statuses    = $vertical['lead_statuses'] ?? [];
            $statusStyles = [
                'pending'   => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400',
                'contacted' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
                'converted' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400',
                'rejected'  => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400',
            ];
            $currentStatus = $lead['status'] ?? 'pending';
        @endphp

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Status</h4>

            {{-- Current status badge --}}
            <div class="mb-4">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $statusStyles[$currentStatus] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ $statuses[$currentStatus]['label'] ?? ucfirst($currentStatus) }}
                </span>
            </div>

            {{-- Quick-change buttons --}}
            @if(!empty($statuses))
                <div class="flex flex-wrap gap-2">
                    @foreach($statuses as $key => $meta)
                        @if($key !== $currentStatus)
                            <form method="POST" action="{{ route('leads.update', $lead['id']) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $key }}" />
                                <button type="submit"
                                    class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700/50 transition">
                                    → {{ $meta['label'] }}
                                </button>
                            </form>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Source & Date --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 space-y-4">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Details</h4>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Source</span>
                    <span class="font-medium text-gray-800 dark:text-white/80">
                        {{ $lead['source'] ?? '—' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Type</span>
                    <span class="font-medium text-gray-800 dark:text-white/80">
                        {{ isset($lead['type']) ? ucfirst($lead['type']) : '—' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Plot Size</span>
                    <span class="font-medium text-gray-800 dark:text-white/80">
                        {{ $lead['plotsize'] ?? '—' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Created</span>
                    <span class="font-medium text-gray-800 dark:text-white/80">
                        {{ isset($lead['created_at']) ? \Carbon\Carbon::parse($lead['created_at'])->format('d M Y, H:i') : '—' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Updated</span>
                    <span class="font-medium text-gray-800 dark:text-white/80">
                        {{ isset($lead['updated_at']) ? \Carbon\Carbon::parse($lead['updated_at'])->format('d M Y, H:i') : '—' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Vertical Badge --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Vertical</h4>
            <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-sm font-medium text-orange-700 dark:bg-orange-500/10 dark:text-orange-400">
                {{ $vertical['name'] }}
            </span>
        </div>

    </div>
</div>

@endsection

