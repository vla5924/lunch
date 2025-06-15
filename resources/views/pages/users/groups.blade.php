@extends('layouts.app')

@section('title', __('users.groups') . ': ' . $user->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('users.users'), route('users.index')],
    [$user->name, route('users.show', $user->id)],
], 'active' => __('users.groups')])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('users.groups', $user->id) }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('users.groups')</label>
                <select multiple class="form-control" name="group_ids[]">
                    @foreach ($groups as $group)
                    <option value="{{ $group->id }}" {{ $user->groups->contains($group) ? 'selected' : '' }}>{{ $group->name }}</option>
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
