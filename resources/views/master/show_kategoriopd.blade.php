@foreach ($data_kategori as $datas)
    <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="tab-{{ $datas->id }}" role="tabpanel">
        <h4>Tahapan Inovasi</h4>
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="myTable">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Wilayah</th>
                        <th>Aktif</th>
                        <th style="width: 100px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas->opd as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ @$item->opd->nama }}</td>
                            <td>
                                @if (@$item->opd->provinsi_id != null)
                                    PROVINSI {{ @$item->opd->provinsi->name }}
                                @elseif (@$item->opd->kabkota_id != null)
                                    {{ ucwords(@$item->opd->kota->name) }}
                                @elseif (@$item->opd->kecamatan_id != null)
                                    KECAMATAN {{ @$item->opd->kecamatan->name }}
                                @elseif (@$item->opd->kelurahan_id != null)
                                    KELURAHAN {{ @$item->opd->kelurahan->name }}
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('master.kategoriopd.switch', ['id' => $item->id]) }}"
                                    method="post">
                                    @csrf

                                    @if ($item->is_aktif == 1)
                                        <button class="btn m-1 btn-block btn-sm btn-success" type="submit"
                                            onclick="if(!confirm('Apakah anda ingin mengubah data ini menjadi No?')){return false;}">Yes</button>
                                    @else
                                        <button class="btn m-1 btn-block btn-sm btn-danger" type="submit"
                                            onclick="if(!confirm('Apakah anda ingin mengubah data ini menjadi Yes?')){return false;}">No</button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                @if (in_array(Auth::user()->role, [1, 3, 4]) || (Auth::user()->role == 5 && $item->opd->maker_id == Auth::user()->id))
                                    <button data-target="#modalPopup" data-toggle="modal"
                                        onclick="modal({{ $item->id }}, 'kategori_opd')"
                                        class="btn m-1 btn-block btn-sm btn-warning"><i
                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <form style="all: unset" action="{{ route('opd.delete', ['id' => $item->id]) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn m-1 btn-block btn-sm btn-danger"
                                            onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i
                                                class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endforeach
