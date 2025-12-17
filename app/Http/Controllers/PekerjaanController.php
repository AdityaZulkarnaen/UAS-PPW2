<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PekerjaanController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->get('keyword');
        $data = Pekerjaan::withCount('pegawai')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")->orWhere('deskripsi', 'like', "%{$keyword}%");
            })->paginate(5)->withQueryString();
        return view('pekerjaan.index', compact('data'));
    }

    public function add() {
        return view('pekerjaan.add');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $data = new Pekerjaan();
        $data->nama = $request->nama;
        $data->deskripsi = $request->deskripsi;

        if ($data->save()) {
            return redirect()->route('pekerjaan.index')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('pekerjaan.index')->with('error', 'Data tidak tersimpan');
        }
    }

    public function edit(Request $request) {
        $data = Pekerjaan::findOrFail($request->id);
        return view('pekerjaan.edit', compact('data'));
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $data = Pekerjaan::findOrFail($request->id);

        $data->nama = $request->nama;
        $data->deskripsi = $request->deskripsi;

        if ($data->save()) {
            return redirect()->route('pekerjaan.index')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('pekerjaan.index')->with('error', 'Data tidak tersimpan');
        }
    }

    public function destroy(Request $request) {
        Pekerjaan::findOrFail($request->id)->delete();
        return redirect()->route('pekerjaan.index')->with('success', 'Data terhapus');
    }
}
