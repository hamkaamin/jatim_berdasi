<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $data = Faq::all();
        return view('master.faq', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Faq;
        } else {
            $data = Faq::findOrFail($request->id);
        }
        $data->pertanyaan = $request->pertanyaan;
        $data->jawaban = $request->jawaban;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Faq::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
