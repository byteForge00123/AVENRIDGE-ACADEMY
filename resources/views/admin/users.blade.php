@extends('layouts.app')
@section('title', 'Users and roles')
@section('content')
<div class="admin-shell">
    @include('admin.partials.nav')
    <section class="admin-content">
        <span class="eyebrow">Access management</span><h1 class="display">Users & roles</h1>
        <p class="muted">Only administrators can change account roles. Do not grant administrative access unless it is required.</p>
        <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>User</th><th>Created</th><th>Role</th><th>Update</th></tr></thead><tbody>
            @foreach ($users as $user)
                <tr><td><strong>{{ $user->name }}</strong><br>{{ $user->email }}</td><td>{{ $user->created_at->format('M j, Y') }}</td><td><span class="tag">{{ ucfirst($user->role) }}</span></td><td>@if ($user->is(auth()->user()))<span class="muted">Current account</span>@else<form method="POST" action="{{ route('admin.users.role', $user) }}">@csrf @method('PATCH')<label class="sr-only" for="role-{{ $user->id }}">Role for {{ $user->name }}</label><select name="role" id="role-{{ $user->id }}"><option value="student" @selected($user->role === 'student')>Student</option><option value="staff" @selected($user->role === 'staff')>Staff</option><option value="admin" @selected($user->role === 'admin')>Admin</option></select><button class="button button-small" type="submit">Save</button></form>@endif</td></tr>
            @endforeach
        </tbody></table></div>
        <div class="pagination">{{ $users->links('pagination::simple-tailwind') }}</div>
    </section>
</div>
@endsection