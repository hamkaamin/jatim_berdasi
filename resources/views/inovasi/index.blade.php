@extends('layouts.main')

@section('title')
    Inovasi {{ $label }}
@endsection

@section('title-desc')
    Daftar Pengajuan Inovasi dari {{ $label }}
@endsection

@if (Auth::user()->role != 2)
    @section('buttons')
        <a href="{{ route('inovasi.edit', ['id' => 0, 'label' => $label == 'Awards' ? 1 : 0]) }}"
            class="btn btn-primary">Tambah Data</a>
    @endsection
@endif

@section('content')
    @php
    $status_label = 0; @endphp
    @if ($label == 'Awards')
        @php $status_label = '1'; @endphp
    @endif
    <form action="{{ route('inovasi.sent') }}" method="POST" name="kirimInovasi" id="kirimInovasi"
        onsubmit="return confirmSubmit()">
        @csrf

        <div class="row">
            <div class="col-10">
            </div>
            @if (env('APP_OPD_JATIM') == 1)
                <div class="col-2">
                    <button type="submit" class="btn btn-success" id="submitButton"><b>Kirim Ke Jatim Berdasi</b></button>
                    <br><br>
                </div>
            @endif
        </div>
        <div class="row">
            @if (Auth::user()->role != 2)
                <div class="col-12">
                    <div class="row">
                        @foreach ($tahapan as $item)
                            <div class="col-3">
                                <div class="card mb-3 widget-content bg-midnight-bloom">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">{{ $item->nama }}</div>
                                            <div class="widget-subheading">Inovasi Tahap <b>{{ $item->nama }}</b></div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white">
                                                <span>
                                                    @php
                                                        $inov = $item->hasManyInovasi();
                                                        if (
                                                            Auth::user()->role == 3 ||
                                                            Helper::checkUserUmum('provinsi', Auth::user())
                                                        ) {
                                                            $inov = $inov->where(
                                                                'provinsi_id',
                                                                Auth::user()->province_id,
                                                            );
                                                        } elseif (
                                                            Auth::user()->role == 4 ||
                                                            Helper::checkUserUmum('kota', Auth::user())
                                                        ) {
                                                            $inov = $inov
                                                                ->where('user_id', Auth::user()->id)
                                                                ->where('label', $status_label)
                                                                ->get();
                                                        } elseif (Auth::user()->role == 5) {
                                                            $inov = $inov
                                                                ->where('kota_id', Auth::user()->opd->kabkota_id)
                                                                ->where('user_id', Auth::user()->id)
                                                                ->where('label', $status_label);
                                                        } elseif (
                                                            Helper::checkOpd('kecamatan', Auth::user()) ||
                                                            Helper::checkUserUmum('opd-kecamatan', Auth::user())
                                                        ) {
                                                            $inov = $inov->where(
                                                                'kecamatan_id',
                                                                Auth::user()->opd->kecamatan_id,
                                                            );
                                                        } elseif (
                                                            Helper::checkOpd('kelurahan', Auth::user()) ||
                                                            Helper::checkUserUmum('opd-kelurahan', Auth::user())
                                                        ) {
                                                            $inov = $inov->where(
                                                                'kelurahan_id',
                                                                Auth::user()->opd->kelurahan_id,
                                                            );
                                                        }
                                                    @endphp
                                                    {{ $inov->count() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <x-tab-inovasi :tahapan="null" :active="1" />
                    @foreach ($tahapan as $item)
                        <x-tab-inovasi :tahapan="$item" :active="0" />
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">
                    <x-tab-content-inovasi :tahapan="null" :active="1" :kolom="$tahapanKolom" :inovasi="$inovasi"
                        :label="$label" />
                    @foreach ($tahapan as $item)
                        <x-tab-content-inovasi :tahapan="$item" :active="0" :kolom="$tahapanKolom" :inovasi="[]"
                            :label="$label" />
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    @include('script.ubahWilayah')
    @include('script.ubahScopeOpd')
    <script>
        $(document).ready(function() {
            $('#myTable0').DataTable({});
        });

        function sent_inovasi(token) {
            // Get the checkbox element
            // var checkbox = document.getElementById('is_sent[]');
            var form = document.forms.namedItem("kirimInovasi");
            const item = [];
            var act = '/inovasi/sent_inovasi';
            var i;
            for (i = 0; i < form.length; i++) {
                if (form[i].checked) {
                    item.push(form[i].value);
                }
            }
            $.post(act, {
                    _token: token,
                    item: item
                },
                function(data) {
                    // $(modal + 'Isi').html(data);
                    console.log(data);
                });
        }
    </script>
    @foreach ($tahapan as $item)
        <script>
            $(document).ready(function() {
                $('#myTable{{ $item->id }}').DataTable();
            });
        </script>
    @endforeach
    <script>
        $(function() {
            $('[data-toggle="tooltip"]')
        });
    </script>
    <script>
        function confirmSubmit() {
            // Display a confirmation dialog
            return confirm("Apakah Anda yakin ingin mengirimkan ini?");
        }

        document.addEventListener("DOMContentLoaded", function() {
            var checkboxes = document.querySelectorAll('input[name="is_sent[]"]');
            var submitButton = document.getElementById('submitButton');

            function updateSubmitButton() {
                var atLeastOneChecked = false;

                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        atLeastOneChecked = true;
                    }
                });

                submitButton.disabled = !atLeastOneChecked;
            }

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateSubmitButton);
            });

            // Call the function initially to set the initial state of the submit button
            updateSubmitButton();
        });
    </script>

    <script>
        function hapus_data(token, id) {
            if (confirm('Apakah anda yakin menghapus data ini ? ')) {
                if (confirm('Apakah anda benar-benar yakin menghapus ini ? ')) {
                    var routeUrl = "{{ route('inovasi.delete') }}"; // Define the route URL

                    $.post(routeUrl, {
                            _token: token,
                            id: id
                        },
                        function(data) {
                            if (data.success) {
                                $('#container-alert').html(
                                    '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                    '<strong>Success!</strong> ' + data.message +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                    '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                    '</div>');

                                // Reload the page after showing the success message
                                setTimeout(function() {
                                    location.reload();
                                }, 1000); // Adjust the delay time as needed
                            } else {
                                // If there's an error, display the error message
                                alert('Failed to delete data: ' + data.message);
                            }
                        });
                }
            }
        }
    </script>
@endsection
