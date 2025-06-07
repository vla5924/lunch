@extends('layouts.app')

@section('title', __('home.home'))

@section('content')
hello! {{ $user->name }}
@endsection
