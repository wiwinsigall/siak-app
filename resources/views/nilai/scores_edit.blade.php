@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Edit Nilai Siswa</strong></h2>
            <a href="{{ route('nilai.index') }}">Kembali</a>
        </div>

        <div class="card-body">

            {{-- Informasi Siswa --}}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nis">NIS</label>
                    <input type="text" class="form-control input-readonly-white" value="{{ $score->nis }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nama">Nama Siswa</label>
                    <input type="text" class="form-control input-readonly-white" value="{{ $score->siswa->nama }}" readonly>
                </div>
            </div>

            {{-- Form Edit Nilai --}}
            <form method="POST" action="{{ route('nilai.update', [$score->id_registrasi, $mapel->id_mapel]) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_tugas">Nilai Tugas</label>
                            <input type="number" name="nilai_tugas" id="nilai_tugas" class="form-control nilai" value="{{ old('nilai_tugas', $score->nilai_tugas) }}" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_uts">Nilai UTS</label>
                            <input type="number" name="nilai_uts" id="nilai_uts" class="form-control nilai" value="{{ old('nilai_uts', $score->nilai_uts) }}" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_uas">Nilai UAS</label>
                            <input type="number" name="nilai_uas" id="nilai_uas" class="form-control nilai" value="{{ old('nilai_uas', $score->nilai_uas) }}" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_akhir">Nilai Akhir (otomatis)</label>
                            <input type="number" id="nilai_akhir" class="form-control" value="{{ $score->nilai_akhir }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="des_laporan">Capaian Pembelajaran</label>
                            <textarea name="des_laporan" class="form-control">{{ old('des_laporan', $score->des_laporan) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function hitungNilaiAkhir() {
        const tugas = parseFloat(document.getElementById('nilai_tugas').value) || 0;
        const uts   = parseFloat(document.getElementById('nilai_uts').value) || 0;
        const uas   = parseFloat(document.getElementById('nilai_uas').value) || 0;
        const akhir = ((tugas + uts + uas) / 3).toFixed(2);
        document.getElementById('nilai_akhir').value = akhir;
    }

    document.querySelectorAll('.nilai').forEach(input => {
        input.addEventListener('input', hitungNilaiAkhir);
    });

    document.addEventListener('DOMContentLoaded', hitungNilaiAkhir);
</script>
@endsection
