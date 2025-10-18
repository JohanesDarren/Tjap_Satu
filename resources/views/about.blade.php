@extends('layouts.about-app')

@section('title', 'Tentang TJAP SATU')

@section('content')
<link rel="stylesheet" href="{{ asset('../css/about.css') }}">

@include('components.about.hero')
@include('components.about.cerita')
@include('components.about.filosofi')
@include('components.about.tim')
@include('components.about.asal-biji')

@endsection
