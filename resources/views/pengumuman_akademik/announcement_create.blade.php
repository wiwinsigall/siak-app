@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Tambah Pengumuman Akademik</strong></h2>
            <a href="{{ route('pengumuman_akademik.index') }}">Kembali</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pengumuman_akademik.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="file" class="font-weight-bold">Upload File Pengumuman (PDF/DOC/DOCX/PNG/JPG/JPEG)</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" required>
                    @error('file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Preview akan muncul di sini --}}
                <div class="form-group" id="preview-container" style="display: none;">
                    <label class="font-weight-bold">Preview File:</label>
                    <div id="image-preview" style="display: none;">
                        <img id="img-preview" width="100%" />
                    </div>
                    <div id="doc-preview" style="display: none;">
                        <iframe id="file-preview" width="100%" height="500px"></iframe>
                    </div>
                </div>

                <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Preview --}}
<script>
    document.getElementById('file').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');
        const docPreview = document.getElementById('doc-preview');
        const preview = document.getElementById('file-preview');
        const imgPreview = document.getElementById('img-preview');

        // Reset visibility
        imagePreview.style.display = 'none';
        docPreview.style.display = 'none';
        preview.src = '';
        preview.style.display = 'none';

        if (file) {
            const fileURL = URL.createObjectURL(file);
            const fileType = file.type;

            // Handle PDF preview
            if (fileType === 'application/pdf') {
                preview.src = fileURL;
                preview.style.display = 'block';
                docPreview.style.display = 'block';
            }
            // Handle image preview (PNG, JPG, JPEG)
            else if (fileType.startsWith('image/')) {
                imgPreview.src = fileURL;
                imagePreview.style.display = 'block';
            }
            // Handle DOC/DOCX preview using Google Docs Viewer
            else if (fileType === 'application/msword' || fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                preview.src = `https://docs.google.com/gview?url=${fileURL}&embedded=true`;
                preview.style.display = 'block';
                docPreview.style.display = 'block';
            }
            previewContainer.style.display = 'block';
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
@endsection
