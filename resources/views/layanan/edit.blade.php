@extends('layouts.app')
@section('title', 'Ubah Layanan')
@section('content')
<div class="page-header">
  <div>
    <span class="eyebrow">Data Master</span>
    <h3>Ubah Layanan</h3>
    <p>Perbarui data jenis layanan yang sudah ada.</p>
  </div>
</div>

<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--wrench" aria-hidden="true"></span>
    Formulir Layanan
  </div>
  <div class="card-body">
    <form action="{{ route('layanan.update', $layanan) }}" method="POST">
      @csrf
      @method('PUT')
      @include('layanan._form')
    </form>
  </div>
</div>
@endsection
