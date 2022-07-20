<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Student;
use App\Models\Borrow;
use App\Models\StudentGroup;
use App\Models\Rayon;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrows = Borrow::latest()->paginate('5');
        $students = Student::all();
        $rombel = StudentGroup::all();
        $rayons = Rayon::all();
        $books = Book::all();
        $users = User::all();
        return view('perpus.borrows.index', compact('borrows','students','rombel','rayons','books','users'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = Student::all();
        $rombel = StudentGroup::all();
        $rayons = Rayon::all();
        $book = Book::all();
        return view('perpus.borrows.create',compact('students','rombel','rayons','book'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $borrow = Borrow::create([
            'nis' => $request->nis,
            'petugas' =>$request->petugas,
            'rayon'=>$request->rayon,
            'rombel'=>$request->rombel,
            'user_id' =>$request->user_id, 
            'book_id' =>$request->book_id, 
            'tanggal_pinjam' => Carbon::now(), 
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status, 
            'keterangan' => $request->keterangan,
        ]);

        session()->flash('success', 'Buku berhasi dipinjam');
        return redirect()->route('perpusku.borrow.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function kembali($id)
    {
        $kembaliBuku = Borrow::find($id);
        $kembaliBuku->update([
            'status' => 'kembali',
            'keterangan' => 'Buku Sudah kembali',
        ]);

        $kembaliBuku->book->where('id', $kembaliBuku->id)->update(['stok' => $kembaliBuku->book->stok + 1]);
        return back();
    }

    public function denda($id)
    {
        $dendaBuku = Borrow::find($id);
        $dendaBuku->update(['keterangan' => 'cepat kembalikan buku !!!, anda diberi denda']);
        $dendaBuku->user->update([
            'denda' => $dendaBuku->user->denda + 3000,
        ]);
        session()->flash('success', 'Pemberian denda berhasil');
        return back();
    }

    public function konfirmasi($id)
    {
        $konfiBuku =  Borrow::find($id);

        if(Book::find($konfiBuku->book_id)->stok <= 0){
            $konfiBuku->update([
                'keterangan' => 'Buku terakhir sudah dipinjam user lain, silakan pinjam buku lain',
            ]);
            session()->flash('illegal','Buku terakhir sudah dipinjam user lain, silakan pinjam buku lain');
            return back();
        }

        $konfiBuku->update([
            'status' => 'pinjam',
            'keterangan' => 'Buku masih dipinjam',
        ]);

        $konfiBuku->book->where('id', $konfiBuku->book_id)
        ->update([ 'stok' => ($konfiBuku->book->stok - 1)]);

        return back();
    }

    public function destroy($id)
    {
        $borrowHapus = Borrow::find($id);
        if($borrowHapus->status == 'kembali' || $borrowHapus->status == 'booking' ){
            $borrowHapus->delete();
        }else{
            $bookStok = Book::find($borrowHapus->book_id);
            $bookStok->stok = $bookStok->stok + 1;
            $bookStok->save();
            $borrowHapus->delete();
        }

        session()->flash('success', 'Berhasil dihapus');
        return back();
    }

    public function print()
    {
        $borrows = Borrow::latest()->paginate(15);
        return view('perpus.borrows.print', compact('borrows'));
    }
}
