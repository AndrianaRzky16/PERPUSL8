@extends('layouts.app')

@section('content')
    <div class="grid-padding text-center">

        @if (session()->get('illegal'))
            <div class="alert alert-success">
                {{ session()->get('illegal') }}
            </div>
        @endif

        <div class="mb-5">

            @if (auth()->user()->role !== 'member')
                <h4 class="d-inline">Peminjaman</h4>
                <button type="button" class="btn btn-sm btn-primary rounded-pill" data-toggle="modal" data-target="#exampleModal">
                    Pinjam buku !
                </button>
                {{-- <a href="{{ route('perpusku.borrow.print') }}" class="btn btn-sm btn-success rounded-pill" >Print</a> --}}
            @else
            <h4 class="d-inline">Buku yg Dipinjam</h4>
            @endif

        </div>

        <table class="table table-stripped rounded-pill">
            <thead style="background-color:#0ec8f8;" class="text-light">
        <th class="p-4">No</th>
        <th class="p-4">Judul Buku</th>
        <th class="p-4">Nis</th>
        <th class="p-4">Nama Peminjam</th>
        <th class="p-4">Rombel</th>
        <th class="p-4">Rayon</th>
        <th class="p-4">Tanggal Pinjam</th>
        <th class="p-4">tanggal Kembali</th>
        <th class="p-4">Petugas</th>
                @if(auth()->user()->role !== 'member')
                    <th class="p-4">Status</th>
                @endif
                {{-- <th class="p-4" colspan="2">aksi</th> --}}
            </thead>

            <tbody>

                @php
                    $no = 0;
                @endphp

                @forelse ($borrows as $borrow)
                    <tr class="justify-item-center" style="position: relative">
                        <td class="p-4">{{ ++$no }}</td>
                        <td class="p-4">{{ $borrow->book_id }}</td>
                        <td class="p-4">{{ $borrow->nis }}</td>
                        <td class="p-4"><b>{{ $borrow->user_id }}</b></td>
                        <td class="p-4">{{ $borrow->rombel }}</td>
                        <td class="p-4">{{ $borrow->rayon }}</td>
                        <td class="p-4">{{ $borrow->tanggal_pinjam }}</td>
                        <td class="p-4">{{ $borrow->tanggal_kembali }}</td>
                        <td class="p-4">{{ $borrow->petugas }}</td>
                        {{-- <td class="p-4"><i>{{ $borrow->keterangan == null ? 'none' : $borrow->keterangan }}</i></td> --}}
                        @if (auth()->user()->role !== 'member')
                                <td class="p-4">
                                    @if(auth()->user()->role !== 'member')
                                        @if($borrow->status == 'kembali')
                                                Peminjam Selesai
                                        @elseif($borrow->status == 'booking')
                                            <form action="{{ route('perpusku.borrow.konfirmasi',$borrow) }}" method="POST">
                                                @csrf
                                                @method('patch')

                                                <button type="submit" class="btn btn-success btn-sm rounded mb-2">
                                                    Konfirmasi
                                                </button>
                                            </form>

                                            <form action="{{ route('perpusku.borrow.destroy',$borrow) }}" onsubmit="return confirm('{{$borrow->book_id}} Mau dihapus ?')" method="POST">
                                                @csrf
                                                @method('delete')

                                                <button type="submit" class="btn btn-danger btn-sm rounded">
                                                    Tolak
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('perpusku.borrow.kembali', $borrow) }}" onsubmit="return confirm('{{ $borrow->book_id}} Mau Dikembalikan?')" method="POST">
                                                @csrf
                                                @method('patch')

                                                <button  class="btn btn-warning btn-sm mb-2"><i class="bi bi-pencil-square"></i></button>
                                            </form>

                                                @csrf
                                                @method('patch')

                                               
                                            </form>
                                        @endif
                                    @endif

                                    {{-- @if (auth()->user()->role !== 'member')
                                        <form action="{{ route('perpusku.borrow.destroy',$borrow) }}" onsubmit="return confirm('Yakin Mau dihapus ?')" method="POST">
                                            @csrf
                                            @method('delete')

                                            <td><button type="submit" style="position: absolute;top:0px;right:0px" class="btn btn-danger">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </form>
                                    @endif --}}


                            </td>
                        @endif

                    </tr>

                    @empty
                        <tr>
                            <td class="bg-danger text-light p-4" colspan="8">Anda Belum meminjam Buku, <b>Ayo Pinjam</b></td>
                        </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade rounded" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: lightblue">
            <h5 class="modal-title text-secondary text-light" id="exampleModalLabel">Tambahkan Peminjam</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('perpusku.borrow.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- @if (auth()->user()->role == 'member')
                        <div class="form-group">
                            <label for="">Nama Peminjam</label>
                            <input type="hidden" class="form-control mb-4" placeholder="nama peminjam" name="user_id" value="{{ old('user_id', auth()->id()) }}">
                            <div class="alert alert-primary">{{ auth()->user()->name }}</div>
                            @error('user_id')
                                <div class="text-danger text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @else --}}
                    <input type="hidden" name="petugas" value="{{ __(auth()->user()->name) }}">
                    <input type="hidden" name="status" value="{{ __('pinjam') }}">
                    <div class="form-group mb-4">
                        <label for="">Nis Peminjam</label>
                        <select name="nis" id="user_id" class="form-control">
                            <option disabled selected>pilih</option>
                            @foreach ($students as $user)
                                <option value="{{ $user->nis }}" data-thumbnail="https://ui-avatars.com/api/background=random">
                                {{ $user->nis }} | {{ $user->nama  }}
                                </option>
                            @endforeach
                        </select>

                        @error('user_id')
                            <div class="text-danger text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                        <div class="form-group mb-4">
                            <label for="">Nama Peminjam</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option disabled selected>pilih</option>
                                @foreach ($students as $user)
                                    <option value="{{ $user->nama }}" data-thumbnail="https://ui-avatars.com/api/background=random">
                                        {{ $user->nama  }}
                                    </option>
                                @endforeach
                            </select>

                            @error('user_id')
                                <div class="text-danger text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    <div class="form-group mb-4">
                        <label for="">Rombel</label>
                        <select name="rombel" id="rombel" class="form-control">
                            <option disabled selected>pilih</option>
                            @foreach ($rombel as $user)
                                <option value="{{ $user->rombel }}" data-thumbnail="https://ui-avatars.com/api/background=random">
                                    {{ $user->rombel  }}
                                </option>
                            @endforeach
                        </select>

                        @error('rombel')
                            <div class="text-danger text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                <div class="form-group mb-4">
                    <label for="">Rayon</label>
                    <select name="rayon" id="user_id" class="form-control">
                        <option disabled selected>pilih</option>
                        @foreach ($rayons as $user)
                            <option value="{{ $user->rayon }}" data-thumbnail="https://ui-avatars.com/api/background=random">
                                {{ $user->rayon  }}
                            </option>
                        @endforeach
                    </select>

                    @error('user_id')
                        <div class="text-danger text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                    {{-- @endif --}}

                    {{-- <div class="form-group">
                        <label for="">Tanggal Meminjam</label>
                        <input type="hidden" class="form-control mb-4" placeholder="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) ) }}">
                        <div class="alert alert-dark rounded">{{ date('d M Y', strtotime(Carbon\Carbon::today()->toDateString())) }}</div>
                        @error('tanggal_pinjam')
                            <div class="text-danger text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}

                    <div class="form-group">
                        <label for="">Tanggal kembali</label>
                        <input type="date" class="form-control mb-4" placeholder="tanggal_kembali" name="tanggal_kembali">
                        {{-- <div class="alert alert-success rounded">{{ date('d M Y', strtotime(Carbon\Carbon::today()->addDays(7)->toDateString())) }}</div> --}}
                        @error('tanggal_kembali')
                            <div class="text-danger text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="">Pilih Buku</label>
                        <select name="book_id" id="book_id" class="form-control">
                            <option selected disabled>pilih</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->title }}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                        @error('tanggal_kembali')
                            <div class="text-danger text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="tulis keterangan peminjam">{{ old('keterangan') }}</textarea>

                        @error('keterangan')
                            <div class="text-danger text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan Buku</button>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection
