<?php

namespace App\Http\Controllers;

use App\Models\StudentGroup;
use Illuminate\Http\Request;


class StudentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $rombel = StudentGroup::latest()->paginate(5);
    
        return view('perpus.rombel.index',compact('rombel'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perpus.rombel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'rombel' => 'required',
            
        ]);
    
        StudentGroup::create($request->all());
     
        return redirect()->route('perpusku.rombel.index')
                        ->with('success','Berhasil Menyimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentGroup  $rombel
     * @return \Illuminate\Http\Response
     */
    public function show(StudentGroup $rombel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentGroup  $rombel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $rombel = StudentGroup::find($id);
        return view('perpus.rombel.edit',compact('rombel'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentGroup  $rombel
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $Update = StudentGroup::find($id);

        $Update->update();
        session()->flash('success', 'berhasil diubah');
        return redirect()->route('perpusku.rombel.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentGroup  $rombel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rombel = StudentGroup::find($id);

        $rombel->delete();
        session()->flash('success', 'Data berhasil dihapus');
        return redirect()->route('perpusku.rombel.index');
    }

}
