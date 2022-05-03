@extends('layouts.main')

@section('title')
    Profil
@endsection

@section('title-desc')
    Pengaturan informasi akun pribadi dan penggantian password
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<form action="{{ route('profil.change-pass') }}" method="post">
				@csrf
				<div class="row my-2">
					<div class="col-3 align-self-center text-right"><label for="">Password Baru <span class="text-danger">*</span></label></div>
					<div class="col-8"><input type="password" name="new_password" class="form-control" required></div>
				</div>
				<div class="row my-2">
					<div class="col-3 align-self-center text-right"><label for="">Konfirmasi Password Baru <span class="text-danger">*</span></label></div>
					<div class="col-8"><input type="password" name="confirm_password" class="form-control" required></div>
				</div>
				<div class="row my-2">
					<div class="col-3"></div>
					<div class="col-8">
						<button class="btn btn-primary" type="submit">Ubah Password</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection