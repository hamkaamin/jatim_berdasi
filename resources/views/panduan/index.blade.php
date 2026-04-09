@extends('layouts.main')

@section('title')
    Master Panduan
@endsection

@section('title-desc')
    Daftar Video Panduan Penggunaan Aplikasi
@endsection


@section('content')
    <div class="main-card mb-3 card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h4>Panduan Inovasi</h4>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=0; @endphp
                                @foreach ($data as $item)
                                    @php
                                        $no++;
                                    @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td><a href="{{ asset($item->path) }}" target="_blank">File</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('script.dataTable')
    @include('script.modal')
    <script>
        $(document).ready(function() {
            $('#myTable1').DataTable();
        });
    </script>
    <script>
        function tambahParameter() {
            $.ajax({
                type: 'POST',
                url: '{{ route('master.parameter.add') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    $('#parameter_container').append(data.msg);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }

        function hapusParameter(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('master.parameter.delete') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#parameter_' + id).remove();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    </script>
@endsection
