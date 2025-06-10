@extends('layouts.app')

@section('title', 'Поставить оценку: ' . $restaurant->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            ['Рестораны', route('restaurants.index')],
            [$restaurant->name, route('restaurants.show', $restaurant->id)],
            ['Оценки', route('evaluations.restaurant', $restaurant->id)],
        ],
        'active' => 'Поставить оценку',
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <form method="POST" action="{{ route('evaluations.store') }}">
            @csrf

            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

            <div class="card-body">
                <div class="form-group">
                    <label>Заметки</label>
                    <textarea class="form-control" name="notes" placeholder="Введите заметки к своей оценке"></textarea>
                </div>
                @foreach ($restaurant->category->criterias as $criteria)
                    <div class="form-group">
                        <label>
                            {{ $criteria->name }}:
                            <span id="criteria-{{ $criteria->id }}">{{ $criteria->max_value }}</span>
                        </label>
                        <div class="text-muted">
                            от {{ $criteria->min_value }}
                            до {{ $criteria->max_value }} включительно
                            с шагом {{ $criteria->step }}
                        </div>
                        <input type="range" class="form-control" name="criteria_values[]" min="{{ $criteria->min_value }}"
                            max="{{ $criteria->max_value }}" step="{{ $criteria->step }}"
                            value="{{ $criteria->max_value }}" list="markers-{{ $criteria->id }}"
                            onchange="Elem.id('criteria-{{ $criteria->id }}').innerText = this.value" required>
                        <input type="hidden" name="criteria_ids[]" value="{{ $criteria->id }}">
                        <datalist id="markers-{{ $criteria->id }}">
                            @foreach ($criteria->values as $value)
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
