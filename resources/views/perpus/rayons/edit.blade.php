@extends('layouts.app')

@section('content')

<div class="grid-padding text-left col-md-8 mx-auto">
    <form action="{{ route('perpusku.rayons.edit', $rayon) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="">Nama Rayon</label>
            <input type="text" class="form-control mb-4" placeholder="Rayons" name="title" value="{{ old('title', $rayon->title) }}">
            @error('title')
                <div class="text-danger text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>

       

        <div class="form-group">
            <button type="submit" class="btn btn-sm btn-primary rounded-pill mt-3">Ubah data Rayon</button>
        </div>
    </form>
</div>

@endsection