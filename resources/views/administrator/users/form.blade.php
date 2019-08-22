<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="row form-group">
        <div class="col col-md-3"><label for="username" class="form-control-label">Username</label></div>
        :<div class="col-12 col-md-7">
            <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Username login" class="form-control">
            <input type="hidden" id="id_user" name="id_user">
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="nama" class="form-control-label">Nama</label></div>
        :<div class="col-12 col-md-7">
            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Nama pengguna !" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="nip" class="form-control-label">Nip</label></div>
        :<div class="col-12 col-md-7">
            <input type="text" class="form-control form-control-sm" id="nip" name="nip" placeholder="Nip pengguna" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="email" class="form-control-label">Email</label></div>
        :<div class="col-12 col-md-7">
            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Alamat Email" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="no_hp" class="form-control-label">Telp / Handphone</label></div>
        :<div class="col-12 col-md-7">
            <input type="number" class="form-control form-control-sm" id="no_hp" name="no_hp" placeholder="Nomor Telp/Hp" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="jabatan" class="form-control-label">Jabatan</label></div>
        :<div class="col-12 col-md-7">
            <input type="text" class="form-control form-control-sm" id="jabatan" name="jabatan" placeholder="Jabatan" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="alamat" class="form-control-label">Alamat</label></div>
        :<div class="col-12 col-md-7"><textarea name="alamat" id="alamat" rows="4" placeholder="Masukkan alamat lengkap" class="form-control form-control-sm"></textarea></div>
    </div>

    <div class="row form-group">
        <div class="col col-md-3"><label for="selectSm" class="form-control-label">Level Pengguna</label></div>
        :<div class="col-12 col-md-7">
            <select name="level" id="level" class="form-control-sm form-control">
                <option value="dosen">Dosen</option>
                <option value="admin">Admin</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-actions form-group">
        <a href="#" id="btn-submit" class="btn btn-sm btn-primary" data-submit=""><i class="fa fa-check"></i> Simpan</a>    
        <a href="#" id="btn-batal" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Batal</a>    
    </div>
</form>
