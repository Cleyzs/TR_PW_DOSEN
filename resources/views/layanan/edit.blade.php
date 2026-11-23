@extends('layouts.app')
@section('title', 'Ubah Layanan')
@section('content')
<div class="page-header">
  <div>
    <h3>Ubah Layanan</h3>
    <p>Perbarui data jenis layanan yang sudah ada.</p>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('layanan.update', $layanan) }}" method="POST">
      @csrf
      @method('PUT')
      @include('layanan._form')
    </form>
  </div>
</div>
@endsection
