@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
        <a href="{{ route('leads.index') }}"
           class="hover:text-brand-500 transition">Leads</a>
        <span>/</span>
        <span class="text-gray-800 dark:text-white/90">New Lead</span>
    </div>
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Add New Lead</h1>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $vertical['name'] }}</p>
</div>

{{-- API / Validation Errors --}}
@if($errors->any())
    <x-ui.alert variant="error" title="Please fix the errors below" class="mb-6">
        <ul class="mt-2 list-disc list-inside text-sm text-gray-600 dark:text-gray-400">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.alert>
@endif

{{-- Form --}}
<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Lead Details</h3>
        </div>

        <form method="POST"
              action="{{ route('leads.store') }}"
              class="p-6 space-y-5">
            @csrf

            @foreach($vertical['lead_fields'] as $field)
                <div>
                    <label for="{{ $field['key'] }}"
                           class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $field['label'] }}
                        @if($field['required'])
                            <span class="text-red-500">*</span>
                        @endif
                    </label>

                    @if($field['type'] === 'select')
                        <select id="{{ $field['key'] }}"
                                name="{{ $field['key'] }}"
                                class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            <option value="">— Select —</option>
                            @foreach($field['options'] as $option)
                                <option value="{{ $option }}" @selected(old($field['key']) === $option)>
                                    {{ ucfirst($option) }}
                                </option>
                            @endforeach
                        </select>

                    @elseif($field['type'] === 'textarea')
                        <textarea id="{{ $field['key'] }}"
                                  name="{{ $field['key'] }}"
                                  rows="4"
                                  placeholder="{{ $field['label'] }}"
                                  class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 resize-none">{{ old($field['key']) }}</textarea>

                    @else
                        <input id="{{ $field['key'] }}"
                               type="{{ $field['type'] }}"
                               name="{{ $field['key'] }}"
                               value="{{ old($field['key']) }}"
                               placeholder="{{ $field['label'] }}"
                               @if($field['required']) required @endif
                               class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300" />
                    @endif

                    @error($field['key'])
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            {{-- Hidden source default --}}
            @if(!collect($vertical['lead_fields'])->pluck('key')->contains('source'))
                <input type="hidden" name="source" value="crm-manual" />
            @endif

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition">
                    Save Lead
                </button>
                <a href="{{ route('leads.index') }}"
                   class="rounded-lg px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

