@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Ubah Pengumuman Akademik</strong></h2>
            <a href="{{ route('pengumuman_akademik.index') }}">Kembali</a>
        </div>

        <div class="card-body">
            {{-- Tampilkan pesan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pengumuman_akademik.update', $pengumuman_akademik->id_pengumuman) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="font-weight-bold">File Lama:</label>
                    <iframe src="{{ asset('storage/pengumuman_akademik/' . $pengumuman_akademik->file) }}" width="100%" height="300px"></iframe>
                </div>

                <div class="form-group">
                    <label for="file" class="font-weight-bold">Ganti File Pengumuman (PDF/DOC/DOCX/PNG/JPG/JPEG)</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" required>
                    @error('file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('pengumuman_akademik.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui  </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
