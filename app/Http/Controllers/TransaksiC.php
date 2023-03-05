<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiC extends Controller
{
    public function index()
    {
        $transaksi = TransaksiM::latest()->paginate(5);
        return new TransaksiR(true, 'List Data Transaksi', $transaksi);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_barang'       => 'required',
            'tanggal_jual'     => 'required',
            'pembeli'     => 'required',
            'nama_barang'   => 'required',
            'qty'     => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $transaksi = TransaksiM::create([
            'id_barang'       => 'required',
            'tanggal_jual'     => 'required',
            'pembeli'     => 'required',
            'nama_barang'   => 'required',
            'qty'     => 'required',
        ]);
        return new TransaksiR(true, 'Data Transaksi Berhasil Ditambahkan!', $transaksi);
    }
    public function show(TransakiM $transaksi){
        return new TransaksiR(true, 'Data Transaksi Ditemukan!', $transaksi);
    }
    public function update(Request $request, TransaksiM $transaksi){
        $validator = Validator::make($request->all(), [
            'id_barang'       => 'required',
            'tanggal_jual'     => 'required',
            'pembeli'     => 'required',
            'nama_barang'   => 'required',
            'qty'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
    
        } else{
            $transaksi->update([
                'id_barang'       => 'required',
                'tanggal_jual'     => 'required',
                'pembeli'     => 'required',
                'nama_barang'   => 'required',
                'qty'     => 'required',
            ]);
        }
        return new TransaksiR(true, 'Data Transaksi Diubah!', $transaksi);
    }
    public function destroy(TransaksiM $transaksi) {
        $transaksi->delete();
        return new TransaksiR(true, 'Data Transaksi Berhasil Dihapus!', null);
    }
}