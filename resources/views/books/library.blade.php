@extends('layouts.dashboard')
@section('title', 'borrow books here')
@section('stylesheet')

<style>
  .max-height{
    /* min-height: 380px!important; */
    max-height: 400px!important;
  }
</style>
@endsection
@section('content')
{{-- top card section --}}
{{-- @livewire('top-board') --}}

{{-- book lists --}}
  @livewire('borrows')
@endsection

{{-- javascripts --}}
@section('scripts')
<script>
  window.addEventListener('swal:success', event => {
    swal({
      title: event.detail.title
      , text: event.detail.message
      , icon: event.detail.type
      , closeModal: true
    , });
  });


  window.addEventListener('swal:confirm', event => {
    swal({
        title: event.detail.title
        , text: event.detail.message
        , icon: event.detail.type
        , buttons: true
        , dangerMode: true
      })
      .then((willDelete) => {
        if (willDelete) {
          Livewire.emit('delete', event.delete.id);
        }
      });
  });

</script>
@endsection
