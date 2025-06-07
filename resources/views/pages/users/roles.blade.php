@extends('layouts.app')

@section('title', 'Роль пользователя: ' . $user->name)

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <form method="POST" action="{{ route('users.update_roles', $user->id) }}">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>Роль</label>
                    <select class="form-control" name="role_id">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}</option>
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
