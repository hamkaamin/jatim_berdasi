<?php

namespace App\Http\Controllers;

use App\Models\DetailTematik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DetailTematikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DetailTematik::with('tematik')->get();
        return view('master.detail_tematik', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new DetailTematik;
        } else {
            $data = DetailTematik::findOrFail($request->id);
        }
        $data->tematik_id = $request->tematik_id;
        $data->nama = $request->nama;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        $data = DetailTematik::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}