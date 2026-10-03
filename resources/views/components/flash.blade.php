@if (session('success'))
    <div class="flash" role="status">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="error-list" role="alert" tabindex="-1">
        <strong>Please check the following:</strong>
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif