@extends('layouts.app')

@section('title', 'Добавить посещение: ' . $restaurant->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Рестораны', route('restaurants.index')],
    [$restaurant->name, route('restaurants.show', $restaurant->id)],
    ['Посещения', route('visits.restaurant', $restaurant->id)],
], 'active' => 'Добавить посещение'])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('visits.store') }}">
        @csrf

        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

        <div class="card-body">
            <div class="form-group">
                <label>Заметки</label>
                <textarea class="form-control" name="notes" placeholder="Введите заметки для посещения"></textarea>
            </div>
            <div class="form-group">
                <label>Дата и время</label>
                <input type="datetime-local" class="form-control" name="datetime" required>
            </div>
            <div class="form-group">
                <label>Группа</label>
                <select class="form-control" name="group_id" required>
                    @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </div>
    </form>
</div>
@endsection
