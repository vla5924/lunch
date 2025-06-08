@extends('layouts.app')

@section('title', 'Изменить комментарий')

@section('breadcrumbs')
@include('components.breadcrumbs')
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <textarea class="form-control" name="text" required>{{ $comment->text }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
@endsection
