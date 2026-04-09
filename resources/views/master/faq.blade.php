@extends('layouts.main')

@section('title')
    Master FAQ
@endsection

@section('title-desc')
    Daftar Pertanyaan dan Jawaban yang sering ditanyakan Pengguna
@endsection

@section('buttons')
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'faq')">Tambah Data</button>
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush" id="myTable">
					<thead class="thead-light">
						<tr>
							<th>No.</th>
							<th>Pertanyaan</th>
							<th>Jawaban</th>
							<th style="width: 100px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->pertanyaan }}</td>
								<td>{!! $item->jawaban !!}</td>
								<td>
									<button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'faq')" class="btn m-1 btn-block btn-sm btn-warning"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
									<form style="all: unset" action="{{ route('master.faq.delete', ['id' => $item->id]) }}" method="post">
										@csrf
										<button type="submit" class="btn m-1 btn-block btn-sm btn-danger" onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('script')
	@include('script.dataTable')
	@include('script.modal')
@endsection