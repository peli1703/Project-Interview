<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
</head>

<body>
    <main style="display: flex; justify-content: center; margin: 8%;">
        <div class="card form-card">
            <h2 style="text-align: center; margin-bottom: 20px;">Login Administrator</h2>

            @if ($errors->any())
                <ul style="width: 100%; background:red; padding: 10px; ">
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
                @endif

                @if (Session::get('gagal'))
                <div style="width: 100%; background:red; padding: 10px; ">
                {{(Session::get('gagal'))}}
                </div>
                @endif


            <form action="{{route('auth')}}" method="POST">
                @csrf
                <div class="input-card">
                    <label for="email">Username :</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="input-card">
                    <label for="password">Password :</label>
                    <input type="password" name="password" id="password">
                </div>
                <button class="button-17" role="button">Masuk</button>
                <a href="{{route('home')}}" class="button-17" style="margin-top: 18px">kembali</a>  
            </form>
        </div>
    </main>
</body>

</html>