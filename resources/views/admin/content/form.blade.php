@extends('layouts.app')
@section('title', $item ? 'Edit '.$definition['label'] : 'Add '.$definition['label'])
@section('content')
<div class="admin-shell">
    @include('admin.partials.nav')
    <section class="admin-content">
        <a class="text-link" href="{{ route('admin.content.index', $type) }}"><i class="icon-sm" data-lucide="arrow-right" style="transform:rotate(180deg)" aria-hidden="true"></i> Back to {{ strtolower($definition['label']) }}</a>
        <span class="eyebrow" style="display:block;margin-top:24px">School content</span><h1 class="display">{{ $item ? 'Edit item' : 'Add an item' }}</h1>
        <form class="form-surface admin-content-form" method="POST" action="{{ $item ? route('admin.content.update', [$type, $item->id]) : route('admin.content.store', $type) }}">@csrf @if ($item) @method('PUT') @endif
            <div class="form-grid">
                @foreach ($definition['fields'] as $key => [$label, $inputType, $rules])
                    @php
                        $value = old($key);
                        if ($value === null && $item) {
                            $value = match ($key) {
                                'is_published' => (bool) $item->published_at,
                                'subjects' => is_array($item->subjects) ? implode(', ', $item->subjects) : $item->subjects,
                                'starts_at', 'ends_at' => $item->{$key}?->format('Y-m-d\TH:i'),
                                default => $item->{$key} ?? null,
                            };
                        }
                        $fieldClass = $inputType === 'textarea' ? 'field field-full' : 'field';
                    @endphp
                    <div class="{{ $fieldClass }}">
                        @if ($inputType === 'checkbox')
                            <div class="checkbox-row"><input id="{{ $key }}" type="checkbox" name="{{ $key }}" value="1" @checked($value)><label for="{{ $key }}">{{ $label }}</label></div>
                        @else
                            <label for="{{ $key }}">{{ $label }}</label>
                            @if ($inputType === 'textarea')<textarea id="{{ $key }}" name="{{ $key }}" required>{{ $value }}</textarea>
                            @else<input id="{{ $key }}" type="{{ $inputType }}" name="{{ $key }}" value="{{ $value }}" @if (str_contains($rules, 'required')) required @endif>@endif
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="form-actions"><button class="button" type="submit">{{ $item ? 'Save changes' : 'Create item' }}</button><a class="text-link" href="{{ route('admin.content.index', $type) }}">Cancel</a></div>
        </form>
    </section>
</div>
@endsection