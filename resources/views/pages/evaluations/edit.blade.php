@extends('layouts.app')

@section('title', __('evaluations.edit_evaluation') . ': ' . $evaluation->restaurant->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            [__('restaurants.restaurants'), route('restaurants.index')],
            [$evaluation->restaurant->name, route('restaurants.show', $evaluation->restaurant->id)],
            [__('evaluations.evaluations'), route('evaluations.restaurant', $evaluation->restaurant->id)],
            [$evaluation->user->name, route('evaluations.show', $evaluation->id)],
        ],
        'active' => __('evaluations.edit_evaluation'),
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
                    <label>@lang('evaluations.notes')</label>
                    <textarea class="form-control" name="notes" placeholder="@lang('evaluations.enter_notes')">{{ $evaluation->notes }}</textarea>
                </div>
                @foreach ($evaluation->criterias as $ce)
                    <hr />
                    <div class="form-group">
                        <label>
                            @if ($ce->criteria->fa_icon)
                                <i class="fas {{ $ce->criteria->fa_icon }} fa-fw"></i>
                            @endif
                            {{ $ce->criteria->name }}:
                            <span id="criteria-{{ $ce->criteria->id }}">{{ $ce->value }}</span>
                        </label>
                        <div class="text-muted">
                            @lang('evaluations.range', [
                                'min' => $ce->criteria->min_value,
                                'max' => $ce->criteria->max_value,
                                'step' => $ce->criteria->step,
                            ])
                        </div>
                        <p>{{ $ce->criteria->description }}</p>
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
