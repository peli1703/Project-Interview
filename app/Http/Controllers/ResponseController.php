<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit( $report_id)
    {
        //ambil data response yang bakal dimunculin, data yang diambil data response yang report_id nya sama kaya $report_id dari path dinamis {report_id}
        //kalau ada, datanya diambil satu  / first()
        //kenapa ga pake firstOrfail() karena nnti bakal munculin not found view, kalau pake first() view nay ttp bakal ditampilin
        $report = Response::where('interview_id', $report_id)->first();
        //karenaan mau kirim data {report_id} buat di route updatenya, jadi biar bia di  pake di blade 
        //kita simpen data ke dinamis $report_id nay ke variable baru yg bakal di compact dan dipanggil di blade nya
        $reportId = $report_id;
        return view('dashboard.petugas.sendres', compact('report','reportId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $report_id)
    {
        $request->validate([
            'status' => 'required',
            'date'  => 'required',
        ]);

        Response::updateOrCreate(
            [
                //untuk mencari data
                'interview_id' => $report_id,
            ],
            [
                //untuk mengirim data
                'status' => $request->status,
                'date' => $request->date,
            ]
        );
        return redirect()->route('data.petugas')->with('responseSuccess', 'Berhasil mengubah response!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }
}
