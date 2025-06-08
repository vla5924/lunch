@extends('layouts.app')

@section('title', 'Пользователи')

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
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Регистрация</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>@include('components.user-link', ['user' => $user])</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $users->links('vendor.pagination.bootstrap-4') }}
@endsection
