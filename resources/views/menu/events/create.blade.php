@extends('layouts.app')

@section('title', 'Create Event - KOI')
@section('page-title')
    Create Event
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('events.store') }}" class="space-y-6">
            @csrf
            @include('menu.events.partials.form-fields')

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('events.index') }}"
                   class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600">
                    Save Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

