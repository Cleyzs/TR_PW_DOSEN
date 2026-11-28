@extends('layouts.app')
@section('title', 'Ubah Pelanggan')
@section('content')
<div class="page-header">
  <div>
    <span class="eyebrow">Data Master</span>
    <h3>Ubah Pelanggan</h3>
    <p>Perbarui data pelanggan yang sudah ada.</p>
  </div>
</div>

<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--users" aria-hidden="true"></span>
    Formulir Pelanggan
  </div>
  <div class="card-body">
    <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
      @csrf
      @method('PUT')
      @include('pelanggan._form')
    </form>
  </div>
</div>
@endsection
