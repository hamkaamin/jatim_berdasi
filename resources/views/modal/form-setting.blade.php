<form action="{{ route('setting.save') }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Setting Tahun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Tahun <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">

                <select class="form-control select22_modal_setting_tahun" id="setting_tahun" name="tahun"
                    required="">

                    {{ $last = 2024 }}
                    {{ $now = date('Y') + 1 }}
                    @for ($i = $now; $i >= $last; $i--)
                        @php
                            $selected = '';
                        @endphp
                        @if ($i == Auth::user()->tahun)
                            @php $selected = 'selected'; @endphp
                        @endif
                        <option {{ $selected }} value="{{ $i }}">
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

@include('script.ck-editor')
