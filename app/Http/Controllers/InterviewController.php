<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use PDF;
use Excel;
use App\Exports\ExcelExport;


class InterviewController extends Controller
{
    /**     
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function login()
     {
     return view('login.login');
     }

     public function landing ()
     {
        return view ('pages.index');
     }

     public function dataPetugas(Request $request)
    {
        $search = $request->search;
        $interviews = Interview::with('response')->orderBy('created_at','DESC')->get();
        return view('dashboard.petugas.dashpetugas', compact('interviews'));

    }

    public function auth(Request $request)
    {
        //Request $request menyimpan data dari inputannya
        $request->validate([
            'email' => 'required|email|:dns',
            'password' => 'required|min:4',
        ]);
       
        // dd($request->all());
        $user = $request->only('email', 'password');
        // simpandata tersebut ke fitur auth sebagai indentitas
        if (Auth::attempt($user)){
            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashadmin');
            }elseif (Auth::user()->role == 'petugas') {
                return redirect()->route('data.petugas');
            }
        }else {
          return redirect()->back()->with('gagal', "Gagal Login, coba lagi");
        }
    
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function exportPDf()
    {
        // ambil data yg akan ditampilkan pada pdf, bisa juga dengan where atau eloquent lainnya dan jangan gunakan pagination
        $data = Interview::with('response')->get()->toArray(); 
        // kirim data yg diambil kepada view yg akan ditampilkan, kirim dengan inisial 
        view()->share('interviews',$data); 
        // panggil view blade yg akan dicetak pdf serta data yg akan digunakan
        $pdf = PDF::loadView('dashboard.print', $data)->setPaper('a4', 'landscape');
        // download PDF file dengan nama tertentu
        return $pdf->download('Data-Pelamar.pdf'); 
    }

    public function exportExcel()
     { 
    // nama file yang akan terdownload
    // selain .xlsx juga bisa .csv
     $file_name = 'Data-Interview'.'.xlsx'; 
     //memanggil file ReportsExport dan mendownload dengan nama seperti $file_name
     return Excel::download(new ExcelExport, $file_name); 
     }

    public function index(Request $request)
    {
        $search = $request->search;
        $interviews = Interview::where('name','LIKE', '%' . $search . '%')->orderBy('created_at','ASC')->get();

        return view('dashboard.admin.dashadmin', compact('interviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $interviews = Interview::all();
        return view('pages.index', compact('interviews'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'age' => 'required|numeric',
                'phone_number' => 'required|numeric',
                'last_education' => 'required',
                'education_name' => 'required',
                'cv_file' => 'required|mimes:pdf,PDF',
            ]);
    
            $cv = $request->file('cv_file');
            $cvfName = rand() . '.' . $cv->extension();
            $path = public_path('assets/cvfile/');
            $cv->move($path, $cvfName);
    
    Interview::create([
        'name' => $request->name,
        'email' => $request->email,
        'age' => $request->age,
        'phone_number' => $request->phone_number,
        'last_education' => $request->last_education,
        'education_name' => $request->education_name,
        'cv_file' => $cvfName,
    ]);
    
    return redirect ('/')->with('successAdd', 'Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function show(Interview $interview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function edit(Interview $interview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Interview $interview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Interview::where('id', $id)->firstOrFail();
        $cv = public_path('assets/cvfile/' .$data['cv_file']);
        unlink($cv);
      $data->delete();
      return redirect()->back();
    }
}
