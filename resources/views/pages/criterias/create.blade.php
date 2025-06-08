@extends('layouts.app')

@section('title', 'Добавить критерий')

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Критерии', route('criterias.index')],
]])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('criterias.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>Название (на английском языке)</label>
                <input type="text" class="form-control" name="name_en" placeholder="Введите название критерия на английском языке" required>
            </div>
            <div class="form-group">
                <label>Название (на русском языке)</label>
                <input type="text" class="form-control" name="name_ru" placeholder="Введите название критерия на русском языке" required>
            </div>
            <div class="form-group">
                <label>Описание (на английском языке)</label>
                <textarea class="form-control" name="description_en" placeholder="Введите описание критерия на английском языке"></textarea>
            </div>
            <div class="form-group">
                <label>Описание (на русском языке)</label>
                <textarea class="form-control" name="description_ru" placeholder="Введите описание критерия на русском языке"></textarea>
            </div>
            <div class="form-group">
                <label>Класс иконки</label>
                <input type="text" class="form-control" name="fa_icon" pattern="fa-[a-z\-0-9]+" placeholder="Введите класс иконки Font Awesome 5 (fa-*)">
            </div>
            <div class="form-group">
                <label>Минимальное значение</label>
                <input type="number" class="form-control" name="min_value" value="1" min="1" step="1" placeholder="Введите минимальное значение критерия (целое число)" required>
            </div>
            <div class="form-group">
                <label>Максимальное значение</label>
                <input type="number" class="form-control" name="max_value" value="10" min="2" step="1" placeholder="Введите максимальное значение критерия (целое число)" required>
            </div>
            <div class="form-group">
                <label>Шаг значения</label>
                <input type="number" class="form-control" name="step" value="1" min="1" step="1" placeholder="Введите шаг значения критерия (целое число)" required>
            </div>
            <div class="form-group">
                <label>Вес критерия</label>
                <input type="number" class="form-control" name="impact" value="1.0" min="0.01" max="1.0" step="0.01" placeholder="Введите вес критерия (вещественное число от 0 до 1)" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </div>
    </form>
</div>
@endsection
