<div class="row my-2 align-items-center" @if($param != null) id="parameter_{{ $param->id }}" @endif>
	<div class="col">
		<input type="hidden" name="parameter_id[]" value="{{ $param != null ? $param->id : 0 }}">
		<input type="text" name="nama[]" class="form-control" required placeholder="Nama Parameter" value="{{ $param != null ? $param->nama : '' }}">
	</div>
	<div class="col-3">
		<input type="number" name="bobot[]" step="any" class="form-control" required placeholder="Bobot" value="{{ $param != null ? $param->bobot : '' }}">
	</div>
	<div class="col-auto">
		<button type="button" class="btn btn-outline-danger" onclick="@if($param != null) hapusParameter({{ $param->id }}); @else $(this).closest('.row').remove(); @endif"><i class="fa fa-times"></i></button>
	</div>
</div>