@foreach ($nodes as $node)
    <tr>
        <td>{{ $prefix . $loop->iteration }}</td>
        <td style="padding-left: {{ $depth * 26 + 8 }}px">
            @if ($depth > 0)
                <i class="fa fa-share fa-rotate-90 text-muted me-1"></i>
            @endif
            <b>{{ $node->bagian !== null && $node->bagian !== '' ? $node->bagian : '-' }}</b>
        </td>
        <td><b>{{ $node->nilai_min }}</b> - <b>{{ $node->nilai_max }}</b></td>
        <td>{{ $node->bobot_nilai }}%</td>
        <td style="white-space: nowrap">
            <button type="button" class="btn m-1 btn-sm btn-success" title="Tambah Anak"
                data-target="#modalPopup" data-toggle="modal"
                onclick="modal(0, '{{ $modalType }}', {{ $node->id }})"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn m-1 btn-sm btn-warning" title="Edit"
                data-target="#modalPopup" data-toggle="modal"
                onclick="modal({{ $node->id }}, '{{ $modalType }}')"><i class="fa fa-edit"></i></button>
            <form style="all: unset" method="post" action="{{ route($deleteRoute, ['id' => $node->id]) }}">
                @csrf
                <button type="submit" class="btn m-1 btn-sm btn-danger" title="Hapus"
                    onclick="if(!confirm('{{ Config::get('delete_confirm') }} Semua sub-aspek di bawahnya ikut terhapus.')){return false;}"><i
                        class="fa fa-trash-alt"></i></button>
            </form>
        </td>
    </tr>
    @include('master.partials.aspek-rows', [
        'nodes' => $node->children,
        'depth' => $depth + 1,
        'prefix' => $prefix . $loop->iteration . '.',
        'modalType' => $modalType,
        'deleteRoute' => $deleteRoute,
    ])
@endforeach
