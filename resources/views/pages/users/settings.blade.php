@extends('layouts.app')

@section('title', 'Настройки')

@section('breadcrumbs')
@include('components.breadcrumbs')
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Приложение</h3>
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

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Безопасность</h3>
        </div>
        <div class="card-body">
            @if(Auth::user()->yandex_id)
            <i class="fas fa-check"></i> Аккаунт Яндекса привязан ({{ Auth::user()->yandex_id }})
            @else
            <a href="{{ route('auth.yandex') }}" class="btn btn-danger">
                <i class="fab fa-yandex mr-2"></i> Привязать аккаунт Яндекса
            </a>
            @endif
        </div>
    </div>
@endsection
