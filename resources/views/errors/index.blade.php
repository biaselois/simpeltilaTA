@extends('layout.main')

@section('content')
<div class="content-wrapper">
    {{-- Pesan Error --}}
    @if (isset($exception))
    <section class="content">
      <div class="container-fluid">
        <div class="alert alert-danger">
          <h4 class="alert-heading">Terjadi Kesalahan</h4>
          <p>{{ $exception}}</p>
        </div>
      </div>
    </section>
    @endif

</div>
@endsection
