 <div class="row my-3">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Tahapan Inovasi</b> <span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         <div class="row">
             <div class="col-12 d-flex align-items-center">

                 <select name="tahapan_id" id="tahapan_id" class="form-control" required>
                     <option value="" selected disabled>-- Pilih Salah Satu --</option>
                     <div id="div_tahapan">

                     </div>
                 </select>
             </div>
         </div>
     </div>
 </div>



 <div class="row my-3">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Inisiator Inovasi</b> <span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         <div class="row">
             @foreach ($inisiator as $item)
                 <div class="col-6 d-flex align-items-center">
                     <input type="radio" id="inisiator_{{ $item->id }}" value="{{ $item->id }}"
                         name="inisiator_id" @if (old('inisiator_id') == $item->id ||
                                 ($data == null && $loop->iteration == 1) ||
                                 ($data != null && $data->inisiator_id == $item->id)) checked @endif><label
                         class="pb-0 mb-0 ml-2" for="inisiator_{{ $item->id }}">{{ $item->nama }}</label>
                 </div>
             @endforeach
         </div>
     </div>
 </div>

 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Inisiator</b> <span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8"><input type="text" required name="nama_inisiator" class="form-control"
             value="{{ $data != null ? $data->nama_inisiator : old('nama_inisiator') }}"></div>
 </div>
 <div class="row my-3">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Jenis Inovasi</b> <span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         <div class="row">
             @foreach ($jenis as $item)
                 <div class="col-6 d-flex align-items-center">
                     <input type="radio" id="jenis_{{ $item->id }}" value="{{ $item->id }}" name="jenis_id"
                         @if (old('jenis_id') == $item->id ||
                                 ($data == null && $loop->iteration == 1) ||
                                 ($data != null && $data->jenis_id == $item->id)) checked @endif><label class="pb-0 mb-0 ml-2"
                         for="jenis_{{ $item->id }}">{{ $item->nama }}</label>
                 </div>
             @endforeach
         </div>
     </div>
 </div>
 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Bentuk Inovasi</b> <span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         <select name="bentuk_id" class="form-control">
             <option value="" selected disabled>-- Pilih Salah Satu --</option>
             @foreach ($bentuk as $item)
                 <option value="{{ $item->id }}" @if (($data != null && $data->bentuk_id == $item->id) || old('bentuk_id') == $item->id) selected @endif>
                     {{ $item->nama }}</option>
             @endforeach
         </select>
     </div>
 </div>

 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center">
         <label><b>Tematik</b> <span class="text-danger">*</span></label>
     </div>
     <div class="col-sm-8">
         <select name="tematik_id" id="tematik_id"
             onchange="get_detail_tematik(this.value, {{ $data ? $data->id : 'null' }})" class="form-control">
             <option value="" selected disabled>-- Pilih Salah Satu --</option>
             @foreach ($tematik as $item)
                 <option value="{{ $item->id }}" @if (($data != null && $data->tematik_id == $item->id) || old('tematik_id') == $item->id) selected @endif>
                     {{ $item->nama }}</option>
             @endforeach
         </select>
     </div>
 </div>

 <div class="detail_tematik">
 </div>


 <div class="row my-3" style="display: none">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Sumber Dana</b> <span
                 class="text-danger">*</span></label></div>

     <div class="row my-3" style="display: none">
         <div class="col-sm-3 d-flex align-items-center"><label><b>Covid 19</b> <span
                     class="text-danger">*</span></label></div>
         <div class="col-sm-8">
             <div class="row">
                 <div class="col-6 d-flex align-items-center">
                     <input type="radio" id="covid_0" value="0" name="covid"
                         @if (old('covid') == 0 || $data == null || ($data != null && $data->covid == 0)) checked @endif><label class="pb-0 mb-0 ml-2"
                         for="covid_0">Non Covid-19</label>
                 </div>
                 <div class="col-6 d-flex align-items-center">
                     <input type="radio" id="covid_1" value="1" name="covid"
                         @if (old('covid') == 1 || ($data != null && $data->covid == 1)) checked @endif><label class="pb-0 mb-0 ml-2"
                         for="covid_1">Covid-19</label>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Urusan Inovasi</b> <span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         <select name="urusan_id[]" style="widows: 100%" required class="js-example-basic-multiple w-100" multiple>
             <option value="" disabled>-- Pilih Salah Satu --</option>
             @foreach ($urusan as $item)
                 <option value="{{ $item->id }}" @if (
                     (old('urusan_id') != null && in_array($item->id, old('urusan_id'))) ||
                         ($data != null && $data->urusan()->where('urusan_id', $item->id)->first() != null)) selected @endif>
                     {{ $item->nama }}</option>
             @endforeach
         </select>
     </div>
 </div>

 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu Ujicoba Inovasi</b> <span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8"><input type="date" required name="waktu_uji_coba" class="form-control"
             value="{{ $data != null ? $data->waktu_uji_coba : old('waktu_uji_coba') }}">
     </div>
 </div>

 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu Penerapan Inovasi</b> <span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8"><input type="date" required name="waktu_penerapan" class="form-control"
             value="{{ $data != null ? $data->waktu_penerapan : old('waktu_penerapan') }}">
     </div>
 </div>

 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center">
         <label><b>Waktu Pengembangan Inovasi</b> <span class="text-danger">*</span></label>
     </div>
     <div class="col-sm-8">
         <div class="row">
             <div class="col-6 d-flex align-items-center">
                 <input type="radio" class="pb-0 mb-0 ml-2" id="pengembangan_1" value="1"
                     name="is_pengembangan" @if ($data != null && $data->is_pengembangan == 1) checked @endif>
                 <label class="pb-0 mb-0 ml-2" for="pengembangan_1">Iya</label>
                 <input type="radio" class="pb-0 mb-0 ml-2" id="pengembangan_0" value="0"
                     name="is_pengembangan" @if ($data == null || ($data != null && $data->is_pengembangan == 0)) checked @endif>
                 <label class="pb-0 mb-0 ml-2" for="pengembangan_0">Tidak</label>
             </div>
         </div>
     </div>
 </div>

 <div class="row my-2" id="waktu_penerapan_row" style="display: none;">
     <div class="col-sm-3 d-flex align-items-center">
         <label><b>Waktu Pengembangan Inovasi</b> <span class="text-danger">*</span></label>
     </div>
     <div class="col-sm-8">
         <input type="date" name="waktu_pengembangan" class="form-control"
             value="{{ $data != null ? $data->waktu_pengembangan : old('waktu_pengembangan') }}">
     </div>
 </div>
 {{-- @foreach ($tahapanKolom as $item)
                        <div class="row my-2">
                            <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu
                                        {{ $item->nama }}
                                        Inovasi</b><span class="text-danger">*</span></label></div>
                            @php
                                $temp =
                                    $data != null
                                        ? $data
                                            ->tahapan()
                                            ->where('tahapan_id', $item->id)
                                            ->first()
                                        : null;
                            @endphp
                            <div class="col-sm-8"><input type="date" required
                                    name="waktu_tahapan_{{ $item->id }}" class="form-control"
                                    @if ($data != null && $temp != null && $temp->pivot->waktu != null) value="{{ date('Y-m-d', strtotime($temp->pivot->waktu)) }}" @else value="{{ old('waktu_tahapan_' . $item->id) }}" @endif>
                            </div>
                        </div>
                    @endforeach --}}
 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Rancang bangun dan pokok perubahan
                 yang
                 dilakukan</b><span class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         {{-- <textarea id="inputText" oninput="countWords()" rows="4" cols="50"></textarea> --}}



         <textarea name="rancang_bangun" oninput="countWords()" class="form-control" required id="inputText">
@if ($data != null)
{!! $data->rancang_bangun !!}
@else
{!! old('rancang_bangun') !!}
@endif
</textarea>
         <b><span class="text-danger"> * Minimal 300 Kata</span></b>
         <p>Jumlah Kata: <span id="wordCount">0</span></p>
         <p>Kurang Kata: <span id="wordCountLess">300</span></p>
         <p id="warningMessage" style="color: red; display: none;">Minimum 300 words required.</p>
     </div>
 </div>
 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Tujuan Inovasi</b><span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         <textarea name="tujuan" required class="ck-editor" id="editor2">
@if ($data != null)
{!! $data->tujuan !!}
@else
{!! old('tujuan') !!}
@endif
</textarea>
     </div>
 </div>
 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Manfaat yang diperoleh</b><span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         <textarea name="manfaat" required class="ck-editor" id="editor3">
@if ($data != null)
{!! $data->manfaat !!}
@else
{!! old('manfaat') !!}
@endif
</textarea>
     </div>
 </div>
 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Hasil Inovasi</b><span
                 class="text-danger">*</span></label></div>
     <div class="col-sm-8">
         <textarea name="hasil" class="ck-editor" required id="editor1">
@if ($data != null)
{!! $data->hasil !!}
@else
{!! old('hasil') !!}
@endif
</textarea>
     </div>
 </div>
 @php
     $anggaran = 'Anggaran (Jika diperlukan)';
 @endphp
 @if (Auth::user()->role == 4 || Auth::user()->role == 5)
     @php $anggaran = 'Surat Pengantar Pemda'; @endphp
 @endif
 <div class="row my-2" style="display:none">
     <div class="col-sm-3 d-flex align-items-center"><label><b>{{ $anggaran }}</b></label>
     </div>
     <div class="col-sm-8"><input type="file" name="anggaran" accept=".jpg,.jpeg,.png,.pdf">
         @if ($data != null)
             <br><a href="{{ $data->anggaran }}" target="_blank">Download File Anggaran</a>
         @endif
     </div>
 </div>

 <div class="row my-2" style="display: none">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Anggaran (Jika
                 diperlukan)</b></label>
     </div>
     <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_anggaran">
         @if ($data != null)
             <br><a href="{{ $data->file_anggaran }}" target="_blank">Download
                 File
                 Anggaran</a>
         @endif
     </div>
 </div>
 <div class="row my-2" style="display: none">
     <div class="col-sm-3 d-flex align-items-center"><label><b>File Rancang Bangun</b></label></div>
     <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_rancang_bangun">
         @if ($data != null)
             <br><a href="{{ $data->file_rancang_bangun }}" target="_blank">Download
                 File
                 Rancang Bangun</a>
         @endif
     </div>
 </div>
 <div class="row my-2" style="display: none">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Profil Bisnis (.ppt) (Jika
                 ada)</b></label>
     </div>
     <div class="col-sm-8"><input accept=".jpg,.jpeg,.png,.pdf" type="file" name="profil_bisnis">
         @if ($data != null)
             <br><a href="{{ $data->profil_bisnis }}" target="_blank">Download File
                 Profil
                 Bisnis</a>
         @endif
     </div>
 </div>

 <div class="row my-2">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Dokumen HAKI </b></label>
     </div>
     <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_dokumen_haki">
         @if ($data != null)
             <br><a href="{{ $data->file_dokumen_haki }}" target="_blank">Download
                 File
                 Dokumen HAKI</a>
         @endif
     </div>
 </div>

 <div class="row my-2" style="display: none">
     <div class="col-sm-3 d-flex align-items-center"><label><b>Penghargaan</b></label></div>
     <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_penghargaan">
         @if ($data != null)
             <br><a href="{{ $data->file_penghargaan }}" target="_blank">Download
                 File
                 Penghargaan</a>
         @endif
     </div>
 </div>
 @include('script.ck-editor')
 <script>
     $(document).ready(function() {
         $('.js-example-basic-multiple').select2();
     });
 </script>
