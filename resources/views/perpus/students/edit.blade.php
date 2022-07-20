@extends('layouts.app')

@section('content')

<div class="grid-padding text-left col-md-8 mx-auto">
    <form action="{{ route('perpusku.students.edit', $student) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="">nis</label>
            <input type="int" class="form-control mb-4" placeholder="NIS" name="nis" value="{{ old('nis') }}">
            @error('nis')
                <div class="text-danger text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="">nama</label>
            <input type="text" class="form-control mb-4" placeholder="nama" name="nama" value="{{ old('nama') }}">
            @error('nama')
                <div class="text-danger text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div> 
        <div class="form-group mb-4">
            <label for="">Pilih Rombel</label>
            <select name="rombel_id" id="rombel_id" class="form-control">
                <option selected disabled>pilih</option>
                @foreach ($rombel as $rombel)
                    <option value="{{ $rombel->id }}">{{ $rombel->rombel }}</option>
                @endforeach
            </select>
            @error('rombel_id')
                <div class="text-danger text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label for="">Pilih Rayon</label>
            <select name="rayon_id" id="rayon_id" class="form-control">
                <option selected disabled>pilih</option>
                @foreach ($rayons as $rayon)
                    <option value="{{ $rayon->id }}">{{ $rayon->rayon }}</option>
                @endforeach
            </select>
            @error('rayon_id')
                <div class="text-danger text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{--<div class="form-group p-5">
            <label for="">Photo Buku</label>
            <br>
            <img src="{{ Storage::url($book->photo) }}" class="img rounded p-4  " height="150px" width="150px" alt="photo {$book->name}">
            <button class="btn btn-primary rounded-pill" style="cursor: default;">Mau ganti gambar ? isi kembali</button>
            <input class="form-control" type="file" name="photo">

            @error('photo')
                <div class="text-danger text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>--}}

        {{--<div class="form-group">
            <label for="">Sinopsis</label>
            <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control">{{ old('deskripsi', $book->deskripsi) }}</textarea>

            @error('deskripsi')
                <div class="text-danger text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>--}}

        <div class="form-group">
            <button type="submit" class="btn btn-sm btn-primary rounded-pill mt-3">Ubah data Siswa</button>
        </div>
    </form>
</div>

@endsection
