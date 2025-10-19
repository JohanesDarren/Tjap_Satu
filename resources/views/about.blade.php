@extends('layouts.about-app')

@section('title', 'Tentang TJAP SATU')

@section('content')
@include('components.header')

@include('components.about.hero')
@include('components.about.cerita')
@include('components.about.filosofi')
@include('components.about.tim')
@include('components.about.asal-biji')

@include('components.footer')
@endsection
