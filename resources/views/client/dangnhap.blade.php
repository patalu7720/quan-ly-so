<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'Quản lý hợp đồng' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body style="background-color: #f5f5f9;">
    <div class="container-fluid">
        <div class="row"> 
            <div class="col-10 col-md-6 col-lg-5 position-absolute top-50 start-50 translate-middle">
                <div class="shadow p-3 mb-5 bg-body rounded">
                    <form action="{{ route('dangnhap') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <p class="font-monospace" style="font-size: 18px; font-weight: bold; font-style:italic">Website Quản lý SO</p>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="username">
                                    <label for="floatingInput">Tài khoản</label>
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password">
                                    <label for="floatingPassword">Mật khẩu</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="login" style="padding: 8px">Đăng nhập</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
