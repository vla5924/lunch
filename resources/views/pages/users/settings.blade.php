@extends('layouts.app')

@section('title', 'Настройки')

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Настройки приложения</h3>
        </div>
        <form method="POST" action="{{ route('users.settings') }}">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>@lang('settings.application_language')</label>
                    <select class="form-control" name="locale" required>
                        @foreach ($locales as $locale => $name)
                            <option value="{{ $locale }}" {{ Auth::user()->locale == $locale ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">@lang('settings.save')</button>
            </div>
        </form>
    </div>
@endsection
