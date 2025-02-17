<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\KategoriInovasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class JuriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juri = Juri::get();
        $data_kategori = KategoriInovasi::orderBy('id','asc')->get();
        return view('master.juri', compact('juri','data_kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     public function save(Request $request)
     {
        if ($request->id == 0) {
            $data = new Juri();
        } else {
            $data = Juri::findOrFail($request->id);
        }
        
        $data->user_id = $request->user_id;
        $data->kategori_id = $request->kategori_id;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
     }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function delete(Request $request)
    {
        $data = Juri::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}