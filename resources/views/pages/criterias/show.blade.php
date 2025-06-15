@extends('layouts.app')

@section('title', $criteria->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('criterias.criterias'), route('criterias.index')],
], 'active' => $criteria->name])
@endsection

@section('content')
@include('components.form-alert')

<div class="card">
<div class="card-body">
    <div class="row">
        <div class="col-12 col-sm-3">
            <div class="info-box bg-light">
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">@lang('criterias.min_value')</span>
                    <span class="info-box-number text-center text-muted mb-0">
                        {{ $criteria->min_value }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-3">
            <div class="info-box bg-light">
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">@lang('criterias.max_value')</span>
                    <span class="info-box-number text-center text-muted mb-0">
                        {{ $criteria->max_value }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-3">
            <div class="info-box bg-light">
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">@lang('criterias.step')</span>
                    <span class="info-box-number text-center text-muted mb-0">
                        {{ $criteria->step }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-3">
            <div class="info-box bg-light">
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">@lang('criterias.weight')</span>
                    <span class="info-box-number text-center text-muted mb-0">
                        {{ $criteria->impact }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
    <div class="col-12 col-md-12 col-lg-8">
        <p>{{ $criteria->description }}</p>
        @lang('criterias.related_categories')
        <ul>
            @foreach ($criteria->categories as $category)
            <li>
                <a href="{{ route('categories.show', $category->id) }}">
                    {{ $category->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <div class="mt-3 mb-5">
            @can('edit criterias')
            <a class="btn btn-info btn-sm" href="{{ route('criterias.edit', $criteria->id) }}">
                <i class="fas fa-pencil-alt"></i> @lang('criterias.edit')
            </a>
            @endcan
            @can('delete criterias')
            <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $criteria->id }}">
                <i class="fas fa-trash"></i> @lang('criterias.delete')
            </button>
            <form method="POST" action="{{ route('criterias.destroy', $criteria->id) }}" id="destroy-{{ $criteria->id }}" hidden>
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>

        <div class="text-muted">
            <p class="text-sm">
                @lang('criterias.icon')
                @if($criteria->fa_icon)
                <i class="d-block fas {{ $criteria->fa_icon }}"></i>
                @else
                <b class="d-block">@lang('criterias.none')</b>
                @endif
            </p>
            <p class="text-sm">
                @lang('criterias.created_at')
                <b class="d-block">{{ $criteria->created_at }}</b>
            </p>
            <p class="text-sm">
                @lang('criterias.created_by')
                <b class="d-block">@include('components.user-link', ['user' => $criteria->user])</b>
            </p>
        </div>
    </div>
    </div>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection
