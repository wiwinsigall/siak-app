@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Pengumuman Akademik</strong></h2>
            @php
                $role = session('role');
            @endphp

            {{-- Tombol Tambah hanya untuk staff --}}
            @if (auth()->user()->role === 'staff')
                <div>
                    <a href="{{ route('pengumuman_akademik.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            @endif
        </div>

        <div class="card-body">
            {{-- Tampilkan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="row">
                @foreach ($pengumuman_akademik as $p)
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <iframe src="{{ asset('storage/pengumuman_akademik/' . $p->file) }}" width="100%" height="500px"></iframe>
                            </div>

                            {{-- Tombol Edit dan Hapus hanya untuk staff --}}
                            @if (auth()->user()->role === 'staff')
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ route('pengumuman_akademik.edit', $p->id_pengumuman) }}" class="btn btn-primary">Ubah</a>
                                    <form action="{{ route('pengumuman_akademik.delete', $p->id_pengumuman) }}" method="POST" 
                                        onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
