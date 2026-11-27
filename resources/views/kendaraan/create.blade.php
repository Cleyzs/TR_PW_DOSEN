@extends('layouts.app')
@section('title', 'Tambah Kendaraan')
@section('content')
<h3 class="mb-3">Tambah Kendaraan</h3>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('kendaraan.store') }}" method="POST">
        @csrf
        @include('kendaraan._form')
    </form>
</div></div>
@endsection