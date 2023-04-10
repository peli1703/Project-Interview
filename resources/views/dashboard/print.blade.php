<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Data Interview</title>
</head>
<body>
    <h2 style="text-align:center; margin-bottom:20px">Data Keseluruhan Interview</h2>
    <table style="width: 100%">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Phone Number</th>
            <th>Last Education</th>
            <th>Education Name</th>
            <th>status</th>
            <th>Schedule</th>
        </tr>
        @php
        $no = 1;
        @endphp
        
        @foreach ($interviews as $inter)
            <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $inter ['name']}}</td>
                    <td>{{ $inter ['email']}}</td>
                    <td>{{ $inter ['age']}}</td>
                    <td>{{ $inter ['phone_number']}}</td>
                    <td>{{ $inter ['last_education']}}</td>
                    <td>{{ $inter ['education_name']}}</td>


                    
                    <td>
                        {{-- cek apakah ada data report ini sudah memiliki relasi dengan data dari with('response') --}}
                        @if ($inter['response'])
                            {{-- kalau ada hasil relasinya, tampilkan bagian status --}}
                            {{ $inter['response']['status']}}
                        @else
                        {{-- kalau ga ada tampilkan tanda ini - --}}
                            -
                        @endif
                    </td>

                    <td>
                    {{-- cek apakah ada data report ini sudah memiliki relasi dengan data dari with('response') --}}
                        @if ($inter['response']['status'] == "diterima")
                              {{-- kalau ada hasil relasinya, tampilkan bagian pesan --}}
                            {{ $inter['response']['date']}}
                        @else
                        {{-- kalau ga ada tampilkan tanda ini - --}}
                            -
                        @endif
                    </td>
            </tr>
            @endforeach
        </thead>
    </table>
</body>
</html>