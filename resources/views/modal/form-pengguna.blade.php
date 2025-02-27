<form action="{{ route('pengguna.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Nama <span class="text-danger">*</span></label></div>
            <div class="col-sm-8"><input type="text" name="name" class="form-control" required
                    value="{{ $data != null ? $data->name : '' }}"></div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Username <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8"><input type="text" name="username" class="form-control" required
                    value="{{ $data != null ? $data->username : '' }}"></div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Email <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8"><input type="email" name="email" class="form-control" required
                    value="{{ $data != null ? $data->email : '' }}"></div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Telepon </label>
            </div>
            <div class="col-sm-8"><input type="number" name="phone" class="form-control"
                    value="{{ $data != null ? $data->phone : '' }}"></div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Akses Menu </label>
            </div>
            <div class="col-sm-8">
                <ul>
                    <li><input {{ $data != null && $data->menu_inotek == 1 ? 'checked' : '' }} type="checkbox"
                            name="menu_inotek" id="tmb_menu_inotek"> <label for="tmb_menu_inotek">Inotek</label></li>
                    <li><input {{ $data != null && $data->menu_iga == 1 ? 'checked' : '' }} type="checkbox"
                            name="menu_iga" id="tmb_menu_iga"> <label for="tmb_menu_iga">IGA</label></li>
                    <li><input {{ $data != null && $data->menu_kovablik == 1 ? 'checked' : '' }} type="checkbox"
                            name="menu_kovablik" id="tmb_menu_kovablik"> <label for="tmb_menu_kovablik">Kovablik</label>
                    </li>
            </div>
        </div>
        <div class="row my-2" style="display: none;">
            <div class="col-sm-4 d-flex align-items-center"><label>Jabatan</label></div>
            <div class="col-sm-8">
                <select name="jabatan_id" class="form-control">
                    <option value="" selected>-- Pilih Salah Satu --</option>
                    @foreach ($jabatan as $item)
                        <option value="{{ $item->id }}" @if ($data != null && $data->jabatan_id == $item->id) selected @endif>
                            {{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row my-2" style="display: none;">
            <div class="col-sm-4 d-flex align-items-center"><label>Golongan</label></div>
            <div class="col-sm-8">
                <select name="golongan_id" class="form-control">
                    <option value="" selected>-- Pilih Salah Satu --</option>
                    @foreach ($golongan as $item)
                        <option value="{{ $item->id }}" @if ($data != null && $data->golongan_id == $item->id) selected @endif>
                            {{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($data == null)
            <div class="row my-2">
                <div class="col-sm-4 d-flex align-items-center"><label>Role <span class="text-danger">*</span></label>
                </div>
                <div class="col-sm-8">
                    <select name="role" class="form-control" onchange="ubahRole(this.value)" required>
                        <option disabled selected>-- Pilih Salah Satu --</option>
                        <option value="2">Verifikator</option>
                        <option value="3">Provinsi</option>
                        <option value="4">Admin - OPD Provinsi</option>
                        <option value="5">Kab/Kota</option>
                        <option value="7">Juri</option>
                    </select>
                    <small>Role hanya dapat ditentukan pada saat pembuatan data Pengguna baru. <b>Pastikan data yang
                            dimasukkan pada form ini sudah benar !</b></small>
                </div>
            </div>
            <div class="row my-2">
                <div class="col" id="role_container">

                </div>
            </div>
        @else
            <div class="row my-2">
                <div class="col-sm-4 d-flex align-items-center"><label>Role</label></div>
                <div class="col-sm-8">{{ Helper::getRole($data->role) }}</div>
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
