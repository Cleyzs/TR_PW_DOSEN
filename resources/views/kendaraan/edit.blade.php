@extends('layouts.app')
@section('title', 'Ubah Kendaraan')
@section('content')
<div class="page-header">
  <div>
    <span class="eyebrow">Data Master</span>
    <h3>Ubah Kendaraan</h3>
    <p>Perbarui data unit kendaraan.</p>
  </div>
</div>
<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--car" aria-hidden="true"></span>
    Formulir Kendaraan
  </div>
  <div class="card-body">
    <form action="{{ route('kendaraan.update', $kendaraan) }}" method="POST">
        @csrf
        @method('PUT')
        @include('kendaraan._form')
    </form>
</div></div>
@endsection