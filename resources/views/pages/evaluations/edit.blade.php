@extends('layouts.app')

@section('title', 'Изменить оценку: ' . $evaluation->restaurant->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            ['Рестораны', route('restaurants.index')],
            [$evaluation->restaurant->name, route('restaurants.show', $evaluation->restaurant->id)],
            ['Оценки', route('evaluations.restaurant', $evaluation->restaurant->id)],
            [$evaluation->user->name, route('evaluations.show', $evaluation->id)],
        ],
        'active' => 'Изменить оценку',
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <form method="POST" action="{{ route('evaluations.update', $evaluation->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>Заметки</label>
                    <textarea class="form-control" name="notes" placeholder="Введите заметки к своей оценке">{{ $evaluation->notes }}</textarea>
                </div>
                @foreach ($evaluation->criterias as $ce)
                    <div class="form-group">
                        <label>
                            {{ $ce->criteria->name }}:
                            <span id="criteria-{{ $ce->criteria->id }}">{{ $ce->value }}</span>
                        </label>
                        <div class="text-muted">
                            от {{ $ce->criteria->min_value }}
                            до {{ $ce->criteria->max_value }} включительно
                            с шагом {{ $ce->criteria->step }}
                        </div>
                        <input type="range" class="form-control" name="criteria_values[]"
                            min="{{ $ce->criteria->min_value }}" max="{{ $ce->criteria->max_value }}"
                            step="{{ $ce->criteria->step }}" value="{{ $ce->value }}"
                            list="markers-{{ $ce->criteria->id }}"
                            onchange="Elem.id('criteria-{{ $ce->criteria->id }}').innerText = this.value" required>
                        <input type="hidden" name="criteria_ids[]" value="{{ $ce->criteria->id }}">
                        <datalist id="markers-{{ $ce->criteria->id }}">
                            @foreach ($ce->criteria->values as $value)
                                <option value="{{ $value }}" label="{{ $value }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                @endforeach
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
