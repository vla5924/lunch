@extends('layouts.app')

@section('title', __('groups.create_group'))

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('groups.groups'), route('groups.index')],
]])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('groups.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('groups.name')</label>
                <input type="text" class="form-control" name="name" placeholder="@lang('groups.enter_name')" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('groups.create')</button>
        </div>
    </form>
</div>
@endsection
