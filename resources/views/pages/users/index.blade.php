@extends('layouts.app')

@section('title', __('users.users'))

@section('breadcrumbs')
@include('components.breadcrumbs')
@endsection

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th>@lang('users.id')</th>
                    <th>@lang('users.name')</th>
                    <th>@lang('users.registration')</th>
                    <th>@lang('users.last_activity')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><x-model-link :model="$user" /></td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->onlineAt }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $users->links('vendor.pagination.bootstrap-4') }}
@endsection
