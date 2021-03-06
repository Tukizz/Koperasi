<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Simpanan;
use App\Anggota;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $Anggota = Anggota::all();
        $Simpanan = Simpanan::all();
        return view('admin.simpanan.index', compact(['Anggota', $Anggota], ['Simpanan', $Simpanan]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        $carisimpanan = $request->get('search');
        $Simpanan = Simpanan::where('id','=','%'.$carisimpanan)
        ->orWhere('id','LIKE','%'.$carisimpanan.'%')
        ->orWhere('nm_simpanan','LIKE','%'.$carisimpanan.'%')
        ->orWhere('anggota_id','LIKE','%'.$carisimpanan.'%')
        ->orWhere('tgl_simpanan','LIKE','%'.$carisimpanan.'%')
        ->orWhere('besar_simpanan','LIKE','%'.$carisimpanan.'%')
        ->orWhere('ket','LIKE','%'.$carisimpanan.'%')
        ->paginate(5);

        return view('admin.simpanan.index', compact(['carisimpanan', $carisimpanan], ['Simpanan', $Simpanan]));
    }

    public function create()
    {
        $Anggota = Anggota::all();
        $Simpanan = Simpanan::all();
        return view('admin.simpanan.index', compact(['Anggota', $Anggota], ['Simpanan', $Simpanan]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'nm_simpanan' => 'required',
        'anggota_id' => 'required',
        'tgl_simpanan' => 'required',
        'besar_simpanan' => 'required',
        'ket' => 'min:5',

    ]);


        $Simpanan = new Simpanan;
        $Simpanan->nm_simpanan = $request->nm_simpanan;
        $Simpanan->anggota_id = $request->anggota_id;
        $Simpanan->tgl_simpanan = $request->tgl_simpanan;
        $Simpanan->besar_simpanan = $request->besar_simpanan;
        $Simpanan->ket = $request->ket;

        $Simpanan->save();

        return redirect('admin/simpanan');
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
        $Anggota = Anggota::all();
        $Simpanan = Simpanan::find($id);

        if(!$Simpanan){
            abort(404);
        }
        return view('admin.simpanan.edit', compact(['Anggota']))->with('Simpanan',$Simpanan);
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
        $this->validate($request, [
        'nm_simpanan' => 'required',
        'anggota_id' => 'required',
        'tgl_simpanan' => 'required',
        'besar_simpanan' => 'required',
        'ket' => 'min:5',

    ]);


        $Simpanan = Simpanan::find($id);
        $Simpanan->nm_simpanan = $request->nm_simpanan;
        $Simpanan->anggota_id = $request->anggota_id;
        $Simpanan->tgl_simpanan = $request->tgl_simpanan;
        $Simpanan->besar_simpanan = $request->besar_simpanan;
        $Simpanan->ket = $request->ket;

        $Simpanan->save();

        return redirect('admin/simpanan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Simpanan = Simpanan::find($id);
        $Simpanan->delete();

        return redirect('admin/simpanan');
    }
}
