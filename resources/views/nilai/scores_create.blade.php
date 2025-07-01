@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Input Nilai Siswa Kelas {{ $kelas->nama_kelas }}</strong></h2>
            <a href="{{ route('nilai.index') }}" class="btn text-primary"><i class="nc-icon nc-minimal-left"></i> Kembali</a>
        </div>

        <div class="card-body">

            {{-- Form Nilai --}}
            <form action="{{ route('nilai.store', [$kelas->id_kelas, $mata_pelajaran->id_mapel]) }}" method="POST">
                @csrf
                <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">
                <input type="hidden" name="id_mapel" value="{{ $mata_pelajaran->id_mapel }}">

                <div class="form-group col-md-4">
                    <label>Mata Pelajaran</label>
                    <input type="text" class="form-control" value="{{ $mata_pelajaran->nama_mapel }}" readonly>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Nilai Tugas</th>
                                <th>Nilai UTS</th>
                                <th>Nilai UAS</th>
                                <th>Nilai Akhir</th>
                                <th>Capaian Pembelajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $i => $s)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    {{ $s->nis }}
                                    <input type="hidden" name="nis[]" value="{{ $s->nis }}">
                                </td>
                                <td>{{ $s->nama }}</td>
                                <td><input type="number" name="nilai_tugas[]" class="form-control nilai" required></td>
                                <td><input type="number" name="nilai_uts[]" class="form-control nilai" required></td>
                                <td><input type="number" name="nilai_uas[]" class="form-control nilai" required></td>
                                <td><input type="number" class="form-control nilai-akhir" readonly></td>
                                <td>
                                    <textarea name="des_laporan[]" class="form-control" rows="2"></textarea>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

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
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const tugas = parseFloat(row.querySelector('input[name="nilai_tugas[]"]').value) || 0;
            const uts = parseFloat(row.querySelector('input[name="nilai_uts[]"]').value) || 0;
            const uas = parseFloat(row.querySelector('input[name="nilai_uas[]"]').value) || 0;

            const nilaiAkhir = ((tugas + uts + uas) / 3).toFixed(2);
            const targetInput = row.querySelector('.nilai-akhir');
            if (targetInput) targetInput.value = nilaiAkhir;
        });
    }

    document.querySelectorAll('input.nilai').forEach(input => {
        input.addEventListener('input', hitungNilaiAkhir);
    });

    document.addEventListener('DOMContentLoaded', hitungNilaiAkhir);
</script>
@endsection
