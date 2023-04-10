@extends('layouts.index')

@section('content')

<body>
    <h2 class="title-table">Lamaran Kerja Admin </h2>
<div style="display: flex; justify-content: center; margin-bottom: 30px">
    <a href="{{route ('logout')}}" class="button-17" style="text-align: center; margin-top:-px">Logout</a> 
    <div style="margin-right:10px; margin-left:10px; margin-top:5px"> <b>|</b></div>
    <a href="{{route ('home')}}" class="button-17" style="text-align: center">Home</a>
</div>



<div style="display: flex; justify-content:flex-end; align-items:center">
    <form action="" method="GET">
        @csrf
        <input type="text" name="search" placeholder="cari berdasarkan nama ...">
        <button class="button-17" role="button" style="margin-left:5px;margin-top: -0.1px">Cari</button>
        
    </form>
    <div>
        <form action="" method="GET" style="margin-top:-30px; margin-left:5px ; margin-right: 33px">
            @csrf
            <button class="button-17" role="button">Refresh</button>
        </form>
    </div>
    </div>
    <div class="sec-center" style="margin-top: 5px; margin-right: 33px"> 	
        <input class="dropdown" type="checkbox" style="" id="dropdown" name="dropdown"/>
        <label class="for-dropdown" style="" for="dropdown">Print All <i class="uil uil-arrow-down"></i></label>
        <div class="section-dropdown"> 
            <a href="/export/excel">Print Excel<i class="uil uil-arrow-right"></i></a>
            <input class="dropdown-sub" type="checkbox" id="dropdown-sub" name="dropdown-sub"/>
            <a href="/export/pdf">Print PDF <i class="uil uil-arrow-right"></i></a>
        </div>
    <div>

    </div>
</div>

<div style="padding: 0 30px; margin-top:10px">
    <table>
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Phone Number</th>
            <th>Last Education</th>
            <th>Education Name</th>
            <th>CV File</th>
            <th>Status</th>
            <th>Schedule</th>

        </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
                       @foreach ($interviews as $inter)

            <tr>
                    <td>{{$no++}}</td>
                    <td>{{$inter['name']}}</td>
                    <td>{{$inter['email']}}</td>
                   
                  <td>{{$inter['age']}}</td>

                  @php
                  $telp = substr_replace($inter->phone_number, "62", 0, 1)
                  @endphp

                    @php
                    if ($inter->response) {
                        if ($inter->response->status == "diterima"){
                        $pesanWA = 'Hallo%20' . $inter->name . '! Lamaran pekerjaan  anda ' . 
                        $inter->response['status'] . '%20Silahkan mengunjungi perusahaan kami di tanggal : ' . $inter->response['date'];
                    }
                    else {
                        $pesanWA =  'Hallo%20' . $inter->name . '! Lamaran pekerjaan  anda ' . 
                        $inter->response['status'] ;
                    }
                    }
                @endphp
                    <td><a  href="https://wa.me/{{$telp}}?text={{$pesanWA}}" target="_blank">{{$telp}}</td>
                   
                    <td>{{$inter['last_education']}}</td>
                     <td>{{$inter['education_name']}}</td>
                    <td>
                          <a href="{{asset('assets/cvfile/'. $inter->cv_file)}}" target="_blank">Lihat CV</a>
                            </a>
                    </td>

                    <td>
                        {{-- cek apakah ada data report ini sudah memiliki relasi dengan data dari with('response') --}}
                        @if ($inter->response)
                            {{-- kalau ada hasil relasinya, tampilkan bagian status --}}
                            {{ $inter->response['status']}}
                        @else
                        {{-- kalau ga ada tampilkan tanda ini - --}}
                            -
                        @endif
                    </td>

                    <td>
                        {{-- cek apakah ada data report ini sudah memiliki relasi dengan data dari with('response') --}}
                            @if ($inter->response)
                                  {{-- kalau ada hasil relasinya, tampilkan bagian pesan --}}
                              @if  ($inter->response->status == "diterima")
                              {{\Carbon\Carbon::parse($inter['created_at'])->format('j F Y')}} {{$inter->response->Schedule}}
                              @else
                            {{-- kalau ga ada tampilkan tanda ini - --}}
                                -
                            @endif
                            @endif
                        </td>
            </tr>
            @endforeach
        </tbody>
    </table>    
    
</div>
</body>

@endsection