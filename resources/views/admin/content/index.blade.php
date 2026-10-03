@extends('layouts.app')
@section('title', $definition['label'])
@section('content')
<div class="admin-shell">
    @include('admin.partials.nav')
    <section class="admin-content">
        <span class="eyebrow">School content</span><h1 class="display">{{ $definition['label'] }}</h1>
        <div class="admin-tools"><p class="muted">Manage the content that appears across the school website.</p><a class="button button-small" href="{{ route('admin.content.create', $type) }}">Add item <i class="icon-sm" data-lucide="plus" aria-hidden="true"></i></a></div>
        <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Item</th><th>Details</th><th>Actions</th></tr></thead><tbody>
            @forelse ($items as $item)
                <tr>
                    <td><strong>{{ $item->name ?? $item->title ?? $item->caption }}</strong><br><small>#{{ $item->id }}</small></td>
                    <td>
                        @if ($type === 'programs'){{ $item->level }}
                        @elseif ($type === 'news'){{ $item->category }} · {{ $item->published_at ? 'Published' : 'Draft' }}
                        @elseif ($type === 'events'){{ $item->category }} · {{ $item->starts_at->format('M j, Y g:i a') }}
                        @elseif ($type === 'faculty'){{ $item->position }} · {{ $item->department }}
                        @elseif ($type === 'facilities'){{ $item->category }}
                        @else{{ $item->category }} · {{ $item->image_url }}@endif
                    </td>
                    <td><div class="table-actions"><a class="text-link" href="{{ route('admin.content.edit', [$type, $item->id]) }}">Edit <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a><form method="POST" action="{{ route('admin.content.delete', [$type, $item->id]) }}" onsubmit="return confirm('Delete this item?')">@csrf @method('DELETE')<button class="text-link" type="submit">Delete</button></form></div></td>
                </tr>
            @empty
                <tr><td colspan="3">No content yet. Add the first item to this section.</td></tr>
            @endforelse
        </tbody></table></div>
        <div class="pagination">{{ $items->links('pagination::simple-tailwind') }}</div>
    </section>
</div>
@endsection