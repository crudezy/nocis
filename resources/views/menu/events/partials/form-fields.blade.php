@php
    $contact = (array) ($event->contact_info ?? []);
    $startValue = old(
        'start_at',
        optional($event->start_at)->format('Y-m-d\TH:i')
    );
    $endValue = old(
        'end_at',
        optional($event->end_at)->format('Y-m-d\TH:i')
    );
@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Event Title</label>
        <input type="text" name="title" value="{{ old('title', $event->title) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
        @error('title')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $event->slug) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
        @error('slug')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
    <textarea name="description" rows="4"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('description', $event->description) }}</textarea>
    @error('description')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Start Date & Time</label>
        <input type="datetime-local" name="start_at" value="{{ $startValue }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
        @error('start_at')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">End Date & Time</label>
        <input type="datetime-local" name="end_at" value="{{ $endValue }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
        @error('end_at')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Venue</label>
        <input type="text" name="venue" value="{{ old('venue', $event->venue) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
        @error('venue')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">City</label>
        <input type="text" name="city" value="{{ old('city', $event->city) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
        @error('city')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
        <select name="status"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $event->status) === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Priority</label>
        <select name="priority"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
            @foreach ($priorities as $priority)
                <option value="{{ $priority }}" @selected(old('priority', $event->priority) === $priority)>
                    {{ ucfirst($priority) }}
                </option>
            @endforeach
        </select>
        @error('priority')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Capacity</label>
        <input type="number" name="capacity" min="0" value="{{ old('capacity', $event->capacity) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
        @error('capacity')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="border border-gray-200 rounded-lg p-4 space-y-4">
    <h4 class="text-sm font-semibold text-gray-700">Contact Information (optional)</h4>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs uppercase text-gray-500 mb-1">PIC Name</label>
            <input type="text" name="contact_pic" value="{{ old('contact_pic', $contact['pic'] ?? '') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('contact_pic')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs uppercase text-gray-500 mb-1">Phone</label>
            <input type="text" name="contact_phone" value="{{ old('contact_phone', $contact['phone'] ?? '') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('contact_phone')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs uppercase text-gray-500 mb-1">Email</label>
            <input type="email" name="contact_email" value="{{ old('contact_email', $contact['email'] ?? '') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('contact_email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

