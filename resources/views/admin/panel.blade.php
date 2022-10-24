@extends('layouts.dashboard')
@section('title', Auth::user()->name)
@section('stylesheet')
@endsection
@section('content')
{{-- top card section --}}
@livewire('top-board')

{{-- book lists --}}
<section>
  @livewire('all-books')
</section>
@endsection
