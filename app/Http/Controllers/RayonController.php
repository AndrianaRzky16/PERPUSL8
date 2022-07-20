<?php

namespace App\Http\Controllers;

use App\Models\Rayon;
use Illuminate\Http\Request;

class RayonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rayons = Rayon::latest()->paginate(5);
    
        return view('perpus.rayons.index',compact('rayons'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perpus.rayons.create');
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
            'rayon' => 'required',
        ]);
    
        Rayon::create($request->all());
     
        return redirect()->route('perpusku.rayons.index')
                        ->with('success','Berhasil Menyimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rayon  $rayon
     * @return \Illuminate\Http\Response
     */
    public function show(Rayon $rayon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rayon  $rayon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $rayon = Rayon::find($id);
        return view('perpus.rayons.edit',compact('rayon'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rayon  $rayon
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $Update = Rayon::find($id);

        $Update->update();
        session()->flash('success', ' berhasil diubah');
        return redirect()->route('perpusku.rayons.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rayon  $rayon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rayon = Rayon::find($id);

        $rayon->delete();
        session()->flash('success', 'Data berhasil dihapus');
        return redirect()->route('perpusku.rayons.index');
    }

}