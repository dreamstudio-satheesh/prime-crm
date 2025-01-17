@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="col">
            <h4 class="card-title mb-0 flex-grow-1">Edit Settings</h4>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="app_name" class="form-label">App Name</label>
                <input type="text" class="form-control" id="app_name" name="app.name" value="{{ $settings['app.name'] ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company.name" value="{{ $settings['company.name'] ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="company_email" class="form-label">Company Email</label>
                <input type="email" class="form-control" id="company_email" name="company.email" value="{{ $settings['company.email'] ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="theme_color" class="form-label">Theme Color</label>
                <input type="text" class="form-control" id="theme_color" name="ui.theme_color" value="{{ $settings['ui.theme_color'] ?? '' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>

</div>
@endsection