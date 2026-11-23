@extends('layouts.app')
@section('title', 'Tambah Layanan')
@section('content')
<div class="page-header">
  <div>
    <h3>Tambah Layanan</h3>
    <p>Lengkapi data jenis layanan baru.</p>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('layanan.store') }}" method="POST">
      @csrf
      @include('layanan._form')
    </form>
  </div>
</div>
@endsection
