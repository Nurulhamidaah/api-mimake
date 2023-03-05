<?php

namespace App\Http\Controllers;

use App\Models\BarangM;
use Illuminate\Http\Request;
use App\Http\Resources\BarangR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangC extends Controller
{
    public function index()
    {
        $barang = BarangM::latest()->paginate(5);
        return new BarangR(true, 'List Data Barang', $barang);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_barang'       => 'required',
            'gambar_barang'     => 'required|image|mimes:jpeg,png,jpg,gif,svg,webm',
            'qty'     => 'required',
            'harga'   => 'required',
            'barcode'     => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $image = $request->file('gambar_barang');
        $image->storeAs('public/barang', $image->hashName());
        $barang = BarangM::create([
            'nama_barang'       => 'required',
            'gambar_barang'     => $image->hashName(),
            'qty'     => 'required',
            'harga'   => 'required',
            'barcode'     => 'required',
        ]);
        return new BarangR(true, 'Data Barang Berhasil Ditambahkan!', $barang);
    }
    public function show(BarangM $barang){
        return new BarangR(true, 'Data Barang Ditemukan!', $barang);
    }
    public function update(Request $request, BarangM $barang){
        $validator = Validator::make($request->all(), [
            'nama_barang'       => 'required',
            'qty'     => 'required',
            'harga'   => 'required',
            'barcode'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->hasFile('gambar_barang')) {

            $image = $request->file('gambar_barang');
            $image->storeAs('public/gambar', $image->hashName());

            Storage::delete('public/gambar/'.$barang->image);

            $barang->update([
            'nama_barang'       => 'required',
            'gambar_barang'     => $image->hashName(),
            'qty'     => 'required',
            'harga'   => 'required',
            'barcode'     => 'required',
            ]);
        } else{
            $barang->update([
            'nama_barang'       => 'required',
            'qty'     => 'required',
            'harga'   => 'required',
            'barcode'     => 'required',
            ]);
        }
        return new BarangR(true, 'Data Barang Diubah!', $barang);
    }
    public function destroy(BarangM $barang) {
        Storage::delete('public/barang/'.$barang->image);
        $barang->delete();
        return new BarangR(true, 'Data Barang Berhasil Dihapus!', null);
    }
}