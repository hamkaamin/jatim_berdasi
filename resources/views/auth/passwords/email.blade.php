<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SI Inovasi - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        .box-shadow {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body style="background-image: url({{ asset('bg-login-40.png') }}); background-repeat: no-repeat; background-size: cover; height: 100vh;">
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="row w-75"> 
            <div class="col-12">
                <div class="card box-shadow" style="border-radius: 1em">
                    <div class="card-body">
                        <div class="row">
			                <div class="col-sm-6 d-flex align-items-center">
                                <img src="{{ asset('admin_asset/logo-inovasi-daerah.png') }}" style="max-width: 100%" alt="">
                            </div>
                            <div class="col-sm-6">
                                <h3>Reset Passwords</h3>
                                <hr>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> 

                                    <div class="row mb-0">
                                        <div class="col text-center">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                {{ __('Send Password Reset Link') }}
                                            </button> 
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
