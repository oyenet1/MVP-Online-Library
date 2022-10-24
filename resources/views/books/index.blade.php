@extends('layouts.dashboard')
@section('title', 'list of book')
@section('stylesheet')
@endsection
@section('content')
{{-- top card section --}}
@livewire('top-board')

{{-- book lists --}}
<section>
  @livewire('books')
</section>
@endsection

{{-- javascripts --}}
@section('scripts')

@endsection
