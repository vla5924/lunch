@extends('layouts.app')

@section('title', __('home.home'))

@section('content')
@lang('home.hello'), {{ $user->name }}!
@endsection
