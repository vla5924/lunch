@extends('layouts.app')

@section('title', 'Права пользователя: ' . $user->name)

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('users.update_permissions', $user->id) }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>Права</label>
                <select multiple class="form-control" name="permission_ids[]" size={{ $permissions->count() }}>
                    @foreach ($permissions as $permission)
                    <option value="{{ $permission->id }}" {{ $user->hasPermissionTo($permission->name) ? 'selected' : '' }}>{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
@endsection
