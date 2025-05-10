@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Ubah Pengumuman Akademik</strong></h3>
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

                        <div class="text-right">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Simpan Perubahan</button>
                            <a href="{{ route('pengumuman_akademik.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
