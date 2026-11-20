@extends('layouts.app')
@section('title', 'Ubah Layanan')
@section('content')
<h3 class="mb-3">Ubah Layanan</h3>
<div class="card shadow-sm"><div class="card-body">
  <form action="{{ route('layanan.update', $layanan) }}" method="POST">
    @csrf
    @method('PUT')
    @include('layanan._form')
  </form>
</div></div>
@endsection