<td>
    <form action="{{ route('master.kategoriopd.switch', ['id' => $q->id]) }}" method="post">
        @csrf

        @if ($q->is_aktif == 1)
            <button class="btn m-1 btn-block btn-sm btn-success" type="submit"
                onclick="if(!confirm('Apakah anda ingin mengubah data ini menjadi No?')){return false;}">Yes</button>
        @else
            <button class="btn m-1 btn-block btn-sm btn-danger" type="submit"
                onclick="if(!confirm('Apakah anda ingin mengubah data ini menjadi Yes?')){return false;}">No</button>
        @endif
    </form>
</td>
<td>
    @if (in_array(Auth::user()->role, [1, 3, 4]) || Auth::user()->role == 5)
        <button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $q->id }}, 'kategori_opd')"
            class="btn m-1 btn-block btn-sm btn-warning"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
        <form style="all: unset" action="{{ route('opd.delete', ['id' => $q->id]) }}" method="post">
            @csrf
            <button type="submit" class="btn m-1 btn-block btn-sm btn-danger"
                onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i
                    class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
        </form>
    @endif
</td>
