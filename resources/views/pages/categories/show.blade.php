@extends('layouts.app')

@section('title', __('categories.pollbunch') . ' ' . $category->id)

@section('content')
@include('components.form-alert')

<div class="card">
<div class="card-body">
    <div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        <div class="row">
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">@lang('categories.author')</span>
                <span class="info-box-number text-center text-muted mb-0">
                    @include('components.user-link', ['user' => $category->user])
                </span>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">@lang('categories.created_at')</span>
                <span class="info-box-number text-center text-muted mb-0">{{ $category->created_at }}</span>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> {{ $category->name }}</h3>
        <div class="mt-3 mb-5">
            @can('edit categories')
            <a class="btn btn-info btn-sm" href="{{ route('categories.edit', $category->id) }}">
                <i class="fas fa-pencil-alt"></i> @lang('categories.edit')
            </a>
            @endcan
            @can('delete categories')
            <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $category->id }}">
                    <i class="fas fa-trash"></i> @lang('categories.delete')
            </button>
            <form method="POST" action="{{ route('categories.destroy', $category->id) }}" id="destroy-{{ $category->id }}" hidden>
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>

        <div class="text-muted">
        <p class="text-sm">@lang('categories.unique_identifier')
            <b class="d-block">{{ $category->id }}</b>
        </p>
        </div>
    </div>
    </div>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection
