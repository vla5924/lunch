@extends('layouts.app')

@section('title', 'Группы пользователя: ' . $user->name)

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('users.groups', $user->id) }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>Группы</label>
                <select multiple class="form-control" name="group_ids[]">
                    @foreach ($groups as $group)
                    <option value="{{ $group->id }}" {{ $user->groups->contains($group) ? 'selected' : '' }}>{{ $group->name }}</option>
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
