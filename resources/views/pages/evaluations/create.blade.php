@extends('layouts.app')

@section('title', __('evaluations.evaluate') . ': ' . $restaurant->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            [__('restaurants.restaurants'), route('restaurants.index')],
            [$restaurant->name, route('restaurants.show', $restaurant->id)],
            [__('evaluations.evaluations'), route('evaluations.restaurant', $restaurant->id)],
        ],
        'active' => __('evaluations.evaluate'),
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
                    <label>@lang('evaluations.notes')</label>
                    <textarea class="form-control" name="notes" placeholder="@lang('evaluations.enter_notes')"></textarea>
                </div>
                @foreach ($restaurant->category->criterias as $criteria)
                    <hr />
                    <div class="form-group">
                        <label>
                            @if ($criteria->fa_icon)
                                <i class="fas {{ $criteria->fa_icon }} fa-fw"></i>
                            @endif
                            {{ $criteria->name }}:
                            <span id="criteria-{{ $criteria->id }}">{{ $criteria->max_value }}</span>
                        </label>
                        <div class="text-muted">
                            @lang('evaluations.range', [
                                'min' => $criteria->min_value,
                                'max' => $criteria->max_value,
                                'step' => $criteria->step,
                            ])
                        </div>
                        <p>{{ $criteria->description }}</p>
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
                <button type="submit" class="btn btn-primary">@lang('evaluations.save')</button>
            </div>
        </form>
    </div>

    <style>
        datalist {
            width: 100%;
            display: flex;
            justify-content: space-between;
            box-sizing: border-box;
            padding: 0 10px;
        }

        datalist option {
            width: 1em;
            padding: 0;
            margin: 0;
            text-align: center;
        }
    </style>
@endsection
