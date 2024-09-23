<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - Login</title>
    <link rel="icon" href="{{ asset(env('APP_LOGO', 'login.png')) }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        .box-shadow {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.5);
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js"></script>

</head>

<body
    style="background-image: url({{ asset(env('APP_BACKGROUND_LOGIN') ?? 'login-page-inovasi-daerah.jpg') }}); background-repeat: no-repeat;    background-size: 100% 100%;height: 100vh;background-position: center; ">
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="row">

            <div class="col-lg-12">
                <div class="card box-shadow" style="border-radius: 1em;background-color: rgba(255,255,255,0.4)">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p style="text-align: center; font-size: 14pt"><b>Log In</b></p>
                                <hr>
                                <form onsubmit="return loginUser('{{ csrf_token() }}');" method="POST"
                                    action="{{ route('login') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="username">Username</label>
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username') }}" required
                                                autocomplete="username" autofocus>

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
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0">

                                        <div class="col text-center">
                                            <div class="g-recaptcha mt-4"
                                                data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                                            <div id="txt_google_captcha_usulan"></div>
                                            {{-- <button class="g-recaptcha"
                                                data-sitekey="6LdNA7wpAAAAAEP3b_5cVPE7Y5KN-JEn4j4Y9CG0"
                                                data-callback='onSubmit' data-action='submit'>Submit</button> --}}
                                            <button type="submit" class="btn btn-primary btn-block btnSubmitForm">
                                                {{ __('Login') }}
                                            </button>
                                            @if (env('APP_NAME') == 'BANGKALAN BRAVO')
                                                <a style="background-color: #86AB89"
                                                    href="https://indeks.inovasi.bskdn.kemendagri.go.id/v2/"
                                                    target="_blank" type="button" class="btn btn-block">
                                                    Pendaftaran Lomba Inovasi Perangkat Daerah 2024
                                                </a>
                                                <a style="background-color: #86AB89"
                                                    href="https://docs.google.com/forms/d/e/1FAIpQLScVxbQPpAhohqabU8RglXKDhsOcOzzrtG8xejPjPvdpdA3lIQ/viewform?usp=sf_link"
                                                    target="_blank" type="button" class="btn  btn-block">
                                                    Pendaftaran Lomba Inovasi Masyarakat 2024
                                                </a>

                                                <a style="background-color: #86AB89"
                                                    href="https://drive.google.com/drive/u/0/folders/1K6CKYsqQJkbHHNtMBPk1uH0MWHXYK4KN"
                                                    target="_blank" type="button" class="btn btn-block">
                                                    Pedoman Teknis Lomba Inovasi 2024
                                                </a>
                                            @endif
                                            {{-- @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function loginUser(token) {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                $('.btnSubmitForm').prop('disabled', false);
                $('#txt_google_captcha_usulan').html('Google Captcha Harus Diisi');
                return false;
            } else {
                $('.btnSubmitForm').prop('disabled', true);
                return true;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
</body>

</html>
