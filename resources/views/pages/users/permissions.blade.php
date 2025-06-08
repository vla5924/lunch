@extends('layouts.app')

@section('title', 'Права пользователя: ' . $user->name)

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Выбранные права</h3>
    </div>
    <form method="POST" action="{{ route('users.permissions', $user->id) }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label hidden>Выбранные права</label>
                <select multiple class="form-control" name="permission_ids[]" size={{ $permissions->count() }}>
                    @foreach ($permissions as $permission)
                    <option value="{{ $permission->id }}" {{ $user->hasDirectPermission($permission->name) ? 'selected' : '' }}>{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Фактические права</h3>
    </div>
    <div class="card-body">
        <ul>
            @foreach ($permissions as $permission)
            @if($user->can($permission->name))
            <li>{{ $permission->name }}</li>
            @endif
            @endforeach
        </ul>
        </div>
    </div>
</div>
@endsection
