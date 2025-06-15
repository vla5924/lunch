@extends('layouts.app')

@section('title', __('groups.edit_group') . ': ' . $group->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [[__('groups.groups'), route('groups.index')], [$group->name, route('groups.show', $group->id)]],
        'active' => __('groups.edit_group'),
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <form method="POST" action="{{ route('groups.update', $group->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>@lang('groups.name')</label>
                    <input type="text" class="form-control" name="name" value="{{ $group->name }}"
                        placeholder="@lang('groups.enter_name')" required>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">@lang('groups.save')</button>
            </div>
        </form>
    </div>
@endsection
