@extends('layouts.app')

@section('title', 'Настройки пользователя: ' . $user->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Пользователи', route('users.index')],
    [$user->name, route('users.show', $user->id)],
], 'active' => 'Настройки пользователя'])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Публичная информация</h3>
        </div>
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>Отображаемое имя</label>
                    <input type="text" class="form-control" name="display_name" value="{{ $user->display_name }}"
                        placeholder="Введите имя, которое будут видеть другие пользователи">
                </div>
                <div class="form-group">
                    <label>@lang('settings.notes')</label>
                    <textarea class="form-control" name="notes">{{ Auth::user()->notes }}</textarea>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">@lang('settings.update')</button>
            </div>
        </form>
    </div>
@endsection
