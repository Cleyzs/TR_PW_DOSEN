@extends('layouts.app')
@section('title', 'Tambah Pelanggan')
@section('content')
<div class="page-header">
  <div>
    <h3>Tambah Pelanggan</h3>
    <p>Lengkapi data pelanggan baru.</p>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('pelanggan.store') }}" method="POST">
      @csrf
      @include('pelanggan._form')
    </form>
  </div>
</div>
@endsection
