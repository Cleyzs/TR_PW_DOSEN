@extends('layouts.app')
@section('title', 'Tambah Pelanggan')
@section('content')
<div class="page-header">
  <div>
    <span class="eyebrow">Data Master</span>
    <h3>Tambah Pelanggan</h3>
    <p>Lengkapi data pelanggan baru.</p>
  </div>
</div>

<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--users" aria-hidden="true"></span>
    Formulir Pelanggan
  </div>
  <div class="card-body">
    <form action="{{ route('pelanggan.store') }}" method="POST">
      @csrf
      @include('pelanggan._form')
    </form>
  </div>
</div>
@endsection
