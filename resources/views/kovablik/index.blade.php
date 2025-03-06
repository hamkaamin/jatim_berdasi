@extends('layouts.main')

@section('title')
    Inovasi {{ $label }}
@endsection

@section('title-desc')
    Daftar Pengajuan Inovasi dari {{ $label }}
@endsection

@php
    $display = 'display:block';
@endphp

@if (Auth::user()->role != 2)

    @section('buttons')
        @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
            <a style="{!! $display !!}"
                href="{{ route('kovablik.edit', ['id' => 0, 'label' => 2]) }}"
                class="btn btn-primary">Tambah Data</a>
        @else
            <a onclick="alertKu('warning', 'Fase Usulan sedang tutup');" href="#" class="btn btn-danger">Tambah Data</a>
        @endif
    @endsection
@endif

@section('content')
    @php
    $status_label = 0; @endphp
    @if ($label == 'Awards')
        @php $status_label = '1'; @endphp
    @endif
    <form action="{{ route('kovablik.sent') }}" method="POST" name="kirimInovasi" id="kirimInovasi"
        onsubmit="return confirmSubmit()">
        @csrf

        <div class="row">
            <div class="col-12">
                <!-- Status Filter -->
                <div class="form-group">
                    <label for="statusFilter">Filter Status</label>
                    <select onchange="show_status('{{ csrf_token() }}',this.value,'{{ $area }}','#show_kovablik')"
                        class="form-control" id="statusFilter" name="statusFilter">
                        <option value="">Semua</option>
                        <option value="0">Draft</option>
                        <option value="1">Proses</option>
                        <option value="2">Setuju</option>
                        <option value="3">Tolak</option>
                        <option value="4">Revisi</option>
                        <option value="5">Kirim</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="statusFilter">Kategori</label>
                    <select
                        onchange="show_status('{{ csrf_token() }}',$('#statusFilter').val(),'{{ $area }}','#show_kovablik')"
                        class="form-control" id="kategori_kovablik" name="kategori_kovablik">
                        <option value="">Semua</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if (env('APP_OPD_JATIM') == 1)
                <div class="col-2">
                    <button type="submit" class="btn btn-success" id="submitButton"><b>Kirim Ke Jatim
                            Berdasi</b></button>
                    <br><br>
                </div>
            @endif
        </div>
        <div id="show_kovablik">

        </div>
    </form>
@endsection

@section('script')
    @include('script.ubahWilayah')
    @include('script.ubahScopeOpd')
    <script>
        var loading = `
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>`;

        function show_status(token, status, area, target) {
            var kategori = $('#kategori_kovablik').val();
            $(target).html(loading);
            $.ajax({
                url: '{{ route('kovablik.show_kovablik') }}',
                type: 'POST',
                data: {
                    _token: token,
                    status: status,
                    kategori: kategori,
                    area: area
                },
                success: function(data) {
                    //loading target area
                    $(target).html(data);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText); // Log error response to console
                }
            });
        }
        $(document).ready(function() {
            show_status('{{ csrf_token() }}', $('#statusFilter').val(), '{{ $area }}', '#show_kovablik');

            $('#myTable0').DataTable({});

            // Filter Inovasi by Status
            $('#statusFilter').on('change', function() {
                var selectedStatus = $(this).val();
                var inovasiRows = $('tr.inovasi-row');

                if (selectedStatus) {
                    inovasiRows.hide();
                    inovasiRows.each(function() {
                        var status = $(this).data('status');
                        if (status === selectedStatus) {
                            $(this).show();
                        }
                    });
                } else {
                    inovasiRows.show();
                }
            });
        });

        function sent_kovablik(token) {
            var form = document.forms.namedItem("kirimInovasi");
            const item = [];
            var act = '/inovasi/sent_kovablik';
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
                    console.log(data);
                });
        }
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]')
        });
    </script>
    <script>
        function confirmSubmit() {
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

                submitButton.disabled = atLeastOneChecked;
            }

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateSubmitButton);
            });

            updateSubmitButton();
        });
    </script>

    <script>
        function hapus_data(token, id) {
            if (confirm('Apakah anda yakin menghapus data ini ? ')) {
                if (confirm('Apakah anda benar-benar yakin menghapus ini ? ')) {
                    var routeUrl = "{{ route('kovablik.delete') }}";

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

                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                alert('Failed to delete data: ' + data.message);
                            }
                        });
                }
            }
        }
    </script>
@endsection
