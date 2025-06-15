@extends('layouts.app')

@section('title', __('users.public_information') . ': ' . $user->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('users.users'), route('users.index')],
    [$user->name, route('users.show', $user->id)],
], 'active' => __('users.public_information')])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>@lang('users.display_name')</label>
                    <input type="text" class="form-control" name="display_name" value="{{ $user->display_name }}"
                        placeholder="@lang('users.enter_display_name')">
                </div>
                <div class="form-group">
                    <label>@lang('users.notes')</label>
                    <textarea class="form-control" name="notes" placeholder="@lang('users.enter_notes')">{{ Auth::user()->notes }}</textarea>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">@lang('users.save')</button>
            </div>
        </form>
    </div>
@endsection
