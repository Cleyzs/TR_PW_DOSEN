@extends('layouts.app')
@section('title', 'Tambah Layanan')
@section('content')
<h3 class="mb-3">Tambah Layanan</h3>
<div class="card shadow-sm"><div class="card-body">
  <form action="{{ route('layanan.store') }}" method="POST">
    @csrf
    @include('layanan._form')
  </form>
</div></div>
@endsection