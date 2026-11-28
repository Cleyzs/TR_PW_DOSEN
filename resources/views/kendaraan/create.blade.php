@extends('layouts.app')
@section('title', 'Tambah Kendaraan')
@section('content')
<div class="page-header">
  <div>
    <span class="eyebrow">Data Master</span>
    <h3>Tambah Kendaraan</h3>
    <p>Daftarkan unit baru dan pilih pemiliknya.</p>
  </div>
</div>
<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--car" aria-hidden="true"></span>
    Formulir Kendaraan
  </div>
  <div class="card-body">
    <form action="{{ route('kendaraan.store') }}" method="POST">
        @csrf
        @include('kendaraan._form')
    </form>
</div></div>
@endsection