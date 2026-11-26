@extends('layouts.app')
@section('title', 'Ubah Pelanggan')
@section('content')
<div class="page-header">
  <div>
    <h3>Ubah Pelanggan</h3>
    <p>Perbarui data pelanggan yang sudah ada.</p>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
      @csrf
      @method('PUT')
      @include('pelanggan._form')
    </form>
  </div>
</div>
@endsection
