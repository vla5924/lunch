@extends('layouts.app')

@section('title', __('users.settings'))

@section('breadcrumbs')
    @include('components.breadcrumbs')
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">@lang('users.application')</h3>
        </div>
        <form method="POST" action="{{ route('users.settings.app') }}">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>@lang('users.application_language')</label>
                    <select class="form-control" name="locale" required>
                        @foreach ($locales as $locale => $name)
                            <option value="{{ $locale }}" {{ Auth::user()->locale == $locale ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">@lang('users.save')</button>
            </div>
        </form>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">@lang('users.notifications')</h3>
        </div>
        <form method="POST" action="{{ route('users.settings.notification') }}">
            @csrf

            <div class="card-body">
                <div class="form-check">
                    <input type="checkbox" id="notif-1" class="form-check-input" name="profile_comment"
                        @checked($notif->profile_comment)>
                    <label class="form-check-label" for="notif-1">@lang('users.new_comments_in_profile')</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="notif-2" class="form-check-input" name="comment_reply"
                        @checked($notif->comment_reply)>
                    <label class="form-check-label" for="notif-2">@lang('users.comments_replies')</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="notif-3" class="form-check-input" name="planned_visit"
                        @checked($notif->planned_visit)>
                    <label class="form-check-label" for="notif-3">@lang('users.planned_visits')</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">@lang('users.save')</button>
            </div>
        </form>
    </div>

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">@lang('users.security')</h3>
        </div>
        <div class="card-body">
            @if (Auth::user()->yandex_id)
                <i class="fas fa-check"></i> @lang('users.yandex_account_linked') ({{ Auth::user()->yandex_id }})
                <button type="submit" class="btn btn-danger btn-delete btn-sm"
                    form="remove-yandex-id">@lang('users.unlink')</button>
                <form method="POST" action="{{ route('users.setings.remove_yandex_id') }}" id="remove-yandex-id" hidden>
                    @csrf
                </form>
            @else
                <a href="{{ route('auth.yandex') }}" class="btn btn-danger">
                    <i class="fab fa-yandex mr-2"></i> @lang('users.link_yandex_account')
                </a>
            @endif
        </div>
    </div>
@endsection
