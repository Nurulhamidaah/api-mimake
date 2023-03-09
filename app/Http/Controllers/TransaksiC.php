<?php

namespace App\Http\Controllers;

use App\Models\TransaksiM;
use Illuminate\Http\Request;
use App\Http\Resources\TransaksiR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransaksiC extends Controller
{
    public function index()
    {
        $transaksi = TransaksiM::latest()->paginate(5);

        return new TransaksiR(true, 'List Data Transaksi', $transaksi);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'id_barang'         => 'required',
            'tanggal_jual'      => 'required',
            'pembeli'           => 'required',
            'nama_barang'       => 'required',
            'qty'               => 'required',
            'harga_awal'        => 'required',
            'harga_jual'        => 'required'
        ]);
        
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $transaksi = TransaksiM::create([
            'id_barang'             => $request->id_barang,
            'tanggal_jual'          => $request->tanggal_jual,
            'pembeli'               => $request->pembeli,
            'nama_barang'           => $request->nama_barang,
            'qty'                   => $request->qty,
            'harga_awal'            => $request->harga_awal,
            'harga_jual'            => $request->harga_jual,
            'laba'                  => ($request->harga_jual - $request->harga_awal),
        ]);

        return new TransaksiR(true, 'Data Transaksi Berhasil Ditambahkan', $transaksi);
    }

    public function show(TransaksiM $transaksi){
        return new TransaksiR(true, 'Data Transaksi Ditemukan', $transaksi);
    }

    public function update(Request $request, TransaksiM $transaksi){
        $validator = Validator::make($request->all() , [
            'id_barang'         => 'required',
            'tanggal_jual'      => 'required',
            'pembeli'           => 'required',
            'nama_barang'       => 'required',
            'qty'               => 'required',
            'harga_awal'        => 'required',
            'harga_jual'        => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

            Storage::delete('public/transaksi/'.$transaksi->id_barang);

            $transaksi->update([
                'id_barang'             => $request->id_barang,
                'tanggal_jual'          => $request->tanggal_jual,
                'pembeli'               => $request->pembeli,
                'nama_barang'           => $request->nama_barang,
                'qty'                   => $request->qty,
                'harga_awal'            => $request->harga_awal,
                'harga_jual'            => $request->harga_jual,
                'laba'                  => ($request->harga_jual - $request->harga_awal),
            ]);


        return new TransaksiR(true, 'Data Transaksi Berhasil Diubah', $transaksi);

    }

    public function destroy(TransaksiM $transaksi){
        Storage::delete('public/transaksi/'.$transaksi->id_barang);

        $transaksi->delete();

        return new TransaksiR(true, 'Data Transaksi Berhasil Dihapus', null);
    }
}
