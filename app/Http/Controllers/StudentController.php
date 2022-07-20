<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\Rayon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::latest()->paginate(5);
        $rombel = StudentGroup::all();
        $rayons = Rayon::all();

    
        return view('perpus.students.index',compact('students','rombel','rayons'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('perpus.students.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'nis' => 'required',
        //     'nama' => 'required',
        //     'rombel' => 'required',
        //     'rayon' => 'required',
        // ]);
    
        Student::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'rombel' =>$request->rombel_id,
            'rayon' =>$request->rayon_id,
        ]);
     
        return redirect()->route('perpusku.students.index')
                        ->with('success','Berhasil Menyimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $rayons = Rayon::all(); 
        $rombel = StudentGroup::all();
        return view('perpus.students.edit',compact('student', 'rayons', 'rombel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'rombel' => 'required',
            'rayon' => 'required',
        ]);
            
        $student->update($request->all());
    
        return redirect()->route('perpusku.students.index')
                        ->with('success','Berhasil Update !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
     
        return redirect()->route('perpusku.students.index')
                        ->with('success','Berhasil Hapus !');
    }
}