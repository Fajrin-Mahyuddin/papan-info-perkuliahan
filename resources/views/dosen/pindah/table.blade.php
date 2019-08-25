@if(session('status'))
    <div class="alert alert-success" id="status_alert" data-dismiss="alert" role="alert">{{session('status')}}</div>
@endif
<div class="alert alert-success alert-hapus collapse" role="alert">Success !</div>
<table id="pindah-table" class="table table-striped">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jam</th>
            <th>Tanggal</th>
            <th>status</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>