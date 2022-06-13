<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SI Inovasi - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body style="background-image: url({{ asset('bg-login.jpg') }}); background-repeat: no-repeat; background-size: cover; height: 100vh;">
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="row w-75">
            <div class="col-12 d-flex justify-content-center">
                <div class="row w-100 mb-4">
                    <div class="col mx-4 bg-white border border-dark text-center" style="border-radius: 10%">
                        <a href="https://indeks.inovasi.litbang.kemendagri.go.id/pengumuman" class="text-dark">
                            <img class="" src="{{ asset('pengumuman.png') }}" style="max-width: 100%; max-height: 100px" alt="">
                            <h6>Pengumuman</h6>
                        </a>
                    </div>
                    <div class="col mx-4 bg-white border border-dark text-center" style="border-radius: 10%">
                        <a href="https://indeks.inovasi.litbang.kemendagri.go.id/panduan" class="text-dark">
                            <img src="{{ asset('manual-book.png') }}" style="max-width: 100%; max-height: 100px" alt="">
                            <h6>Manual Book</h6>
                        </a>
                    </div>
                    <div class="col mx-4 bg-white border border-dark text-center" style="border-radius: 10%">
                        <a href="https://indeks.inovasi.litbang.kemendagri.go.id/dokumen" class="text-dark">
                            <img src="{{ asset('buku-petunjuk-teknis.png') }}" style="max-width: 100%; max-height: 100px" alt="">
                            <h6>Petunjuk Teknis</h6>
                        </a>
                    </div>
                    <div class="col mx-4 bg-white border border-dark text-center" style="border-radius: 10%">
                        <a href="{{ route('login') }}" class="text-dark">
                            <img src="{{ asset('login.png') }}" style="max-width: 100%; max-height: 100px" alt="">
                            <h6>Login Aplikasi</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border border-dark">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3>Sign In</h3>
                                <hr>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="username">Username</label>
                                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col text-center">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                {{ __('Login') }}
                                            </button>
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <img src="https://indeks.inovasi.litbang.kemendagri.go.id/assets/logoIGA2021.png" style="max-width: 100%" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
