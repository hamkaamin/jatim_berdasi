@extends('layouts.main')

@section('title')
    {{ $setting['title'] }}
@endsection

@section('title-desc')
    {{ $setting['description'] }}
@endsection


@section('content')
    <div class="row">
        <div class="col">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <form name="frm_{{ $item->id }}" id="frm_{{ $item->id }}" method="POST"
                                    action="{{ route('setting.update', encrypt($item->id)) }}">
                                    @csrf
                                    @method('PUT')
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <span>{{ $item->nama }}</span>
                                    </td>
                                    <td>
                                        @if ($item->is_aktif == 1)
                                            <span class="label label-success div_edit_off_{{ $item->id }}">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="label label-danger div_edit_off_{{ $item->id }}">
                                                Non Aktif
                                            </span>
                                        @endif
                                        <select name="is_aktif" class="div_edit_on_{{ $item->id }}"
                                            style="display: none">
                                            <option {{ $item->is_aktif == 1 ? 'selected' : '' }} value="1">Aktif
                                            </option>
                                            <option {{ $item->is_aktif == 0 ? 'selected' : '' }} value="0">Non Aktif
                                            </option>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <button type="button"
                                            class="btn btn-sm btn-info btn-sm div_edit_off_{{ $item->id }}"
                                            onclick="$('.div_edit_off_{{ $item->id }}').hide();$('.div_edit_on_{{ $item->id }}').show();">
                                            Ubah
                                        </button>
                                        <button onclick="$('#frm_{{ $item->id }}').submit();"
                                            form="frm_{{ $item->id }}" type="submit"
                                            class="btn btn-sm btn-success btn-sm div_edit_on_{{ $item->id }}"
                                            style="display: none">
                                            Simpan
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-sm div_edit_on_{{ $item->id }}"
                                            style="display: none"
                                            onclick="$('.div_edit_off_{{ $item->id }}').show();$('.div_edit_on_{{ $item->id }}').hide();">
                                            Batal
                                        </button>
                                    </td>
                                </form>
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
