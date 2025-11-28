@extends('layouts.app')

@section('title', 'Edit Event - KOI')
@section('page-title')
    Edit Event
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('events.update', $event) }}" class="space-y-6">
            @csrf
            @method('PUT')
            @include('menu.events.partials.form-fields')

            <div class="flex items-center justify-between">
                <a href="{{ route('events.index') }}"
                   class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Back to Events
                </a>
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-5 py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600">
                        Update Event
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

