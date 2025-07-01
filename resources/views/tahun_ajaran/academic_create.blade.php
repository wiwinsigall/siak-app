@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Form Tambah Tahun Ajaran</strong></h2>
            <a href="{{ route('tahun_ajaran.index') }}" class="btn text-primary">Kembali</a>
        </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tahun_ajaran.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="form-select" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ old('tahun_ajaran') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select name="semester" id="semester" class="form-select" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>

            <div class="form-group mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
