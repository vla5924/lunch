@extends('layouts.app')

@section('title', $user->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('users.users'), route('users.index')],
], 'active' => $user->name])
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ $user->ava }}">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                <p class="text-muted text-center">
                    @foreach ($user->roles as $role)
                    {{ Str::ucfirst($role->name) }} 
                    @endforeach
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>@lang('users.telegram_name')</b> <span class="float-right">{{ $user->tg_name }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>@lang('users.telegram_nickname')</b> <a class="float-right" href="//t.me/{{ $user->tg_username }}" target="_blank">{{ $user->tg_username }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>@lang('users.registration')</b> <span class="float-right">{{ $user->created_at }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>@lang('users.last_activity')</b> <span class="float-right">{{ $user->onlineAt }}</span>
                    </li>
                </ul>

                @if($user->id == Auth::user()->id)
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block"><b>@lang('users.edit_information')</b></a>
                @endif
            </div>
        </div>
        @can(['edit users', 'assign groups', 'assign roles', 'assign permissions'])
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">@lang('users.administration')</h3>
            </div>
            <div class="card-body">
                @can('edit users')
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-danger btn-block">@lang('users.public_information')</a>
                @endcan
                @can('assign groups')
                <a href="{{ route('users.groups', $user->id) }}" class="btn btn-danger btn-block">@lang('users.groups')</a>
                @endcan
                @can('assign roles')
                <a href="{{ route('users.roles', $user->id) }}" class="btn btn-danger btn-block">@lang('users.roles')</a>
                @endcan
                @can('assign permissions')
                <a href="{{ route('users.permissions', $user->id) }}" class="btn btn-danger btn-block">@lang('users.permissions')</a>
                @endcan
            </div>
        </div>
        @endcan
    </div>

    <div class="col-12 col-md-8 col-lg-9">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">@lang('users.notes')</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-users mr-1"></i> @lang('users.groups')</strong>
                <p class="text-muted">
                    @foreach($user->groups as $group)
                    {{ $group->name }}
                    @endforeach
                </p>
                <hr />
                <strong><i class="far fa-file-alt mr-1"></i> @lang('users.notes')</strong>
                <p class="text-muted">
                    @if ($user->notes)
                    {{ $user->notes }}
                    @else
                    <i>@lang('users.empty')</i>
                    @endif
                </p>
            </div>
        </div>

        @include('components.comments', ['comments' => $comments, 'commentable' => $user])
    </div>
</div>
@endsection
