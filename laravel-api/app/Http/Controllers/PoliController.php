<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\rs_poli;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poli = rs_poli::all();
        return ['status' => true, 'message' => 'list poli', 'data' => $poli];
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
    public function store(Request $request)
    {
        $last_poli  = rs_poli::latest('poli_id')->first();

        if ($last_poli) {
            $last_poli_id = $last_poli->poli_id;
        } else {
            $last_poli_id = 'P0000';
        }
        
        // create new data
        $poli = new rs_poli();
        $poli->poli_id = ++$last_poli_id;
        $poli->poli = $request->poli;
        $poli->antrian_dibuka_h_minus = $request->antrian_dibuka_h_minus;
        $poli->antrian_ditutup_h_minus = $request->antrian_ditutup_h_minus;
        
        // store into database
        if ($poli->save()) {
            return ['status' => true, 'message' => 'new poli added'];    
        } else {
            return ['status' => false, 'message' => 'something error'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poli = rs_poli::where('poli_id', $id)->first();

        if ($poli) {
            return ['status' => true, 'message' => 'show '.$poli->poli, 'data' => $poli ];
        } else {
            return ['status' => false, 'message' => 'poli not found' ];
        }

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
        $poli = rs_poli::where('poli_id', $id)->first();

        if (!$poli) {
            return ['status' => false, 'message' => 'poli not found' ];
        }

        $poli->poli = $request->poli;
        $poli->antrian_dibuka_h_minus = $request->antrian_dibuka_h_minus;
        $poli->antrian_ditutup_h_minus = $request->antrian_ditutup_h_minus;

        if ($poli->update()) {
            return ['status' => true, 'message' => 'poli updated', 'data' => $poli ];
        } else {
            return ['status' => false, 'message' => 'poli update failed' ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poli = rs_poli::where('poli_id', $id)->first();

        if (!$poli) {
            return ['status' => false, 'message' => 'poli not found' ];
        }

        if ($poli->delete()) {
            return ['status' => true, 'message' => 'poli deleted'];
        } else {
            return ['status' => false, 'message' => 'poli delete failed' ];
        }
    }
}
