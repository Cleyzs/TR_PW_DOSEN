@extends('layouts.app')
@section('title', 'Ubah Kendaraan')
@section('content')
<h3 class="mb-3">Ubah Kendaraan</h3>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('kendaraan.update', $kendaraan) }}" method="POST">
        @csrf
        @method('PUT')
        @include('kendaraan._form')
    </form>
</div></div>
@endsection