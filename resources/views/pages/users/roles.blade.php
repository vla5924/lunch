@extends('layouts.app')

@section('title', __('users.roles') . ': ' . $user->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('users.users'), route('users.index')],
    [$user->name, route('users.show', $user->id)],
], 'active' => __('users.roles')])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <form method="POST" action="{{ route('users.roles', $user->id) }}">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>@lang('users.roles')</label>
                    <select multiple class="form-control" name="role_ids[]" size="{{ $roles->count() }}" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">@lang('users.save')</button>
            </div>
        </form>
    </div>
@endsection
