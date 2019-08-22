<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="row form-group">
        <div class="col col-md-3"><label for="id_dosen" class="form-control-label">Dosen</label></div>
        :<div class="col-12 col-md-7">
        <select name="id_dosen" id="id_dosen" data-live-search="true" data-style="btn-primary" data-size="5" class="selectpicker form-control form-control-sm">
                <option value="">--Pilih--</option>
                @foreach($dosens as $dosen)
                    <option value="{{$dosen->id_dosen}}">{{$dosen->nama}}</option>
                @endforeach
            </select>
            <input type="hidden" id="id_jadwal" name="id_jadwal">
            <input type="hidden" id="id_semester" name="id_semester">
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="id_mk" class="form-control-label">Mata Kuliah</label></div>
        :<div class="col-12 col-md-7">
            <select name="id_mk" id="id_mk" data-live-search="true" data-style="btn-primary" data-size="5" class="selectpicker form-control form-control-sm">
                <option value="">--Pilih--</option>
                @foreach($mks as $mk)
                    <option value="{{$mk->id_mk}}">{{$mk->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="id_kelas" class="form-control-label">Kelas</label></div>
        :<div class="col-12 col-md-7">
            <select name="id_kelas" id="id_kelas" data-style="btn-primary" class="form-control form-control-sm selectpicker">
                <option value="">--Pilih--</option>
                @foreach($kelass as $kelas)
                    <option value="{{$kelas->id_kelas}}">{{$kelas->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="hari" class="form-control-label">Hari</label></div>
        :<div class="col-12 col-md-7">
            <select name="hari" id="hari" data-style="btn-primary" class="form-control form-control-sm selectpicker">
                <option value="">--Pilih--</option>
                <option value="senin">Senin</option>
                <option value="selasa">Selasa</option>
                <option value="rabu">Rabu</option>
                <option value="kamis">Kamis</option>
                <option value="jumat">Jumat</option>
                <option value="sabtu">Sabtu</option>
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="jam_mulai" class="form-control-label">Jam Mulai</label></div>
        :<div class="col-12 col-md-7">
            <input type="text" class="form-control form-control-sm timepicker" id="jam_mulai" name="jam_mulai">
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-3"><label for="jam_akhir" class="form-control-label">Jam Akhir</label></div>
        :<div class="col-12 col-md-7">
            <input type="text" class="form-control form-control-sm timepicker" id="jam_akhir" name="jam_akhir">
        </div>
    </div>
    <hr>
    <div class="form-actions form-group">
        <a href="#" id="btn-submit" class="btn btn-sm btn-primary" data-submit=""><i class="fa fa-check"></i> Simpan</a>    
        <a href="#" id="btn-batal" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Batal</a>    
    </div>
</form>
