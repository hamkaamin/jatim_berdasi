@extends('layouts.main')

@section('title')
    Penilaian Proposal Kovablik
@endsection

@section('title-desc')
    Daftar Pengajuan Proposal Kovablik yang Sudah Disetujui
@endsection

@section('content')
<div class="row">
    <ul class="nav nav-tabs">
        @foreach ($kelompok as $item)
            <li class="nav-item">
                <a data-toggle="tab" href="#kelompok-tab-{{ $item->id }}" 
                    class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                    {{ $item->nama }} 
                    <span class="badge badge-primary">
                        {{ sizeof($item->hasManyKovablik) }}
                    </span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content mt-2">
        @foreach ($kelompok as $data)
            <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="kelompok-tab-{{ $data->id }}" role="tabpanel">
                <div class="col-12">
                    <ul class="nav nav-tabs">
                        @foreach ($data->tahapan as $item)
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tahapan-tab-{{ $data->id }}-{{ $item->id }}" 
                                    class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                                    {{ $item->nama }} 
                                    <span class="badge badge-primary">
                                        {{ $item->proposals->where('kelompok_id', $data->id)->count() }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-2">
                        @foreach ($data->tahapan as $tahap)
                            <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tahapan-tab-{{ $data->id }}-{{ $tahap->id }}" role="tabpanel">
                                <h4>Proposal Kovablik</h4>
                                <table class="table align-items-center table-flush data-table">
                                    <thead class="thead-light">
                                        <tr>
                                            @if ($tahap->id == 1)
                                                <th></th>
                                            @endif
                                            <th>No.</th>
                                            <th>Instansi</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Kelompok</th>
                                            <th>Juri</th>
                                            <th>Nilai</th>
                                            @if ($tahap->id == 1)
                                                <th>Status</th>
                                            @endif
                                            <th>Act</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahap->proposals as $item)
                                            @if ($item->kelompok_id == $data->id)
                                                @php
                                                    $juri_id = \App\Models\JuriKovablik::where('kelompok_id', $item->kelompok_id)->pluck('user_id');
                                                    $user = \App\Models\User::whereIn('id', $juri_id)->pluck('name');

                                                    $penilaian = $item->penilaian->where('tahapan_id', $item->tahapan_id);
                                                    $groupedByJuri = $penilaian->groupBy('pivot.user_id');
                                                    $totalNilai = $groupedByJuri->map(function ($nilai) {
                                                        return $nilai->sum('pivot.nilai');
                                                    });
                                                    $averageNilai = $totalNilai->count() > 0 ? $totalNilai->avg() : 0;

                                                    if($totalNilai->count() > 0){
                                                        $thisJuri = \App\Models\JuriKovablik::where('user_id', Auth::id())->first();
                                                        $penilaianJuri = \App\Models\PenilaianKovablikMap::where('juri_id', $thisJuri->id)->where('proposal_id', $item->id)->first();
                                                        $isLolos = 0;
                                                        if($penilaianJuri != null){
                                                            $isLolos = $penilaianJuri->is_lolos;
                                                        }
                                                    }

                                                    $counter = 1;
                                                @endphp
                                                <tr>
                                                    @if ($tahap->id == 1)
                                                        <td><input type="checkbox" style="transform: scale(2)" name="is_pass[]" class="is_pass" value="{{ $item->id }}"></td>
                                                    @endif
                                                    <td>{{ $counter }}</td>
                                                    <td>{{ $item->instansi }}</td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->kategori->nama}}</td>
                                                    <td>{{ $item->kelompok->nama}}</td>
                                                    <td>{{ implode(', ', $user->toArray()) }}</td>
                                                    <td>{{ $averageNilai == 0 ? '-' : number_format($averageNilai, 2) }}</td>
                                                    @if ($tahap->id == 1)
                                                        <td>
                                                            @if($isLolos == 1)
                                                                Lolos
                                                            @else
                                                                Tidak Lolos
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if ($item->status != 0)
                                                            <a target="_blank"
                                                                href="{{ route('kovablik.export', ['type' => 'pdf', 'id' => $item->id]) }}"
                                                                class="btn m-1 btn-block btn-sm btn-info"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Download Pdf"><i
                                                                    class="fa fa-file-pdf"></i>&nbsp;&nbsp;PDF</a>
                                                            <a target="_blank"
                                                                href="{{ route('kovablik.export', ['type' => 'excel', 'id' => $item->id]) }}"
                                                                class="btn m-1 btn-block btn-sm btn-success"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Download Excel"><i
                                                                    class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                                        @endif
                                                        @if (($item->status == 0 || Auth::user()->role == 2) && $item->status != 2)
                                                            <a href="{{ route('kovablik.edit', ['id' => encrypt($item->id)]) }}"
                                                                class="btn m-1 btn-block btn-sm btn-warning"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Edit Inovasi"><i
                                                                    class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                        @endif
                                                        @if (
                                                            ($item->status != 2 && $item->user_id == Auth::user()->id) ||
                                                                Auth::user()->username == 'salehsayanglatifah' ||
                                                                Auth::user()->username == 'pemdkotkabatest')
                                                            <form style="all: unset"
                                                                action="{{ route('kovablik.delete', ['id' => $item->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn m-1 btn-block btn-sm btn-danger"
                                                                    onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Hapus Inovasi"><i
                                                                        class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                                            </form>
                                                        @endif

                                                        @if (Auth::user()->role == 7)
                                                            <a href="{{ route('penilaian-kovablik.edit', ['id' => encrypt($item->id), 'user_id' => Auth::user()->id]) }}"
                                                                class="btn m-1 btn-block btn-sm btn-warning"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Penilaian Proposal"><i
                                                                    class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                        @else
                                                            <a href="{{ route('penilaian-kovablik.show', ['id' => encrypt($item->id)]) }}"
                                                                class="btn m-1 btn-block btn-sm btn-warning"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Penilaian Proposal"><i
                                                                    class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        <form id="form-lolos" action="{{ route('penilaian-kovablik.pass') }}" method="POST">
            @csrf
            <div id="hidden-inputs"></div>
        </form>
        <button type="button" id="btnPass" class="btn btn-primary d-none" onclick="submitSelectedCheckboxes()">Lolos ke Tahap Wawancara</button>
    </div>
</div>
@endsection

@section('script')
    @include('script.ubahWilayah')
    @include('script.ubahScopeOpd')
    <script>
        $(document).ready(function() {
            $('#myTable0').DataTable({});
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.data-table').each(function() {
                $(this).DataTable({});
            });
        });
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]')
        });
    </script>
    <script>
        function submitSelectedCheckboxes() {
            let selectedCheckboxes = document.querySelectorAll('.is_pass:checked'); // Find checked checkboxes
            let hiddenInputsContainer = document.getElementById('hidden-inputs');
            hiddenInputsContainer.innerHTML = ''; // Clear previous inputs

            // Append checked checkboxes into the hidden form
            selectedCheckboxes.forEach(checkbox => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'is_pass[]';
                input.value = checkbox.value;
                hiddenInputsContainer.appendChild(input);
            });

            // Submit the form
            document.getElementById('form-lolos').submit();
        }
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".is_pass").forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    let anyChecked = document.querySelectorAll(".is_pass:checked").length > 0;
                    document.getElementById("btnPass").classList.toggle("d-none", !anyChecked);
                });
            });
        });
    </script>
@endsection
