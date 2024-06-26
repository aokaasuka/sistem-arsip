<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat KGB</h1>
    </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Riwayat KGB</h6>
            <a href="#" class="btn btn-primary ml-auto" data-toggle="modal" data-target="#exampleModal">Tambah</a>
        </div>

        <div class="card-body">
            <?php if ($message = $this->session->flashdata('message')) : ?>
                <?= $message ?>
                <?php $this->session->unset_userdata('message'); ?>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Golongan</th>
                            <th>Gaji</th>
                            <th>KGB No SK</th>
                            <th>KGB TMT</th>
                            <th>Yad KGB</th>
                            <th>Tahun KGB</th>
                            <th>Bulan KGB</th>
                            <th>KGB Tanggal Surat</th>
                            <th>No SK Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Golongan</th>
                            <th>Gaji</th>
                            <th>KGB No SK</th>
                            <th>KGB TMT</th>
                            <th>Yad KGB</th>
                            <th>Tahun KGB</th>
                            <th>Bulan KGB</th>
                            <th>KGB Tanggal Surat</th>
                            <th>No SK Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($riwayat_kgb as $rkgb) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $rkgb['golongan_ruang']; ?></td>
                                <td><?= $rkgb['gaji']; ?></td>
                                <td><?= $rkgb['kgb_nomor_sk']; ?></td>
                                <td><?= $rkgb['kgb_tmt']; ?></td>
                                <td><?= $rkgb['tanggal_yad_kgb']; ?></td>
                                <td><?= $rkgb['tahun_kgb']; ?></td>
                                <td><?= $rkgb['bulan_kgb']; ?></td>
                                <td><?= $rkgb['kgb_tanggal_surat']; ?></td>
                                <td><?= $rkgb['nomor_sk_terakhir']; ?></td>
                                <td>
                                    <a href="" class="btn btn-warning">Edit</a>
                                    <a href="<?= base_url('riwayatkgb/delete/' . $rkgb['id']); ?>" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah KGB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('pegawai/riwayatkgb', ['id' => 'form_kgb']); ?>
                    <div class="form-group row">
                        <label for="golongan_ruang" class="col-sm-3 col-form-label">Gol. Ruang</label>
                        <div class="col-sm-9">
                            <select class="custom-select" name="golongan_ruang">
                                <option selected disabled hidden>-Pilih-</option>
                                <option value=I>I</option>
                                <option value=II>II</option>
                                <option value=III>III</option>
                                <option value=IV>IV</option>
                                <option value=V>V</option>
                                <option value=VI>VI</option>
                                <option value=VII>VII</option>
                                <option value=VIII>VIII</option>
                                <option value=IX>IX</option>
                                <option value=1X>X</option>
                                <option value=XI>XI</option>
                                <option value=XII>XII</option>
                                <option value=XIII>XIII</option>
                                <option value=XIV>XIV</option>
                                <option value=XV>XV</option>
                                <option value=XVI>XVI</option>
                                <option value=XVII>XVII</option>
                            </select>
                            <?= form_error('golongan_ruang', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gaji_tahun" class="col-sm-3 col-form-label">Gaji Tahun</label>
                        <div class="col-sm-9">
                            <select class="custom-select" name="gaji_tahun">
                                <option selected disabled hidden>-Pilih-</option>
                                <option value="PP Nomor 11 Tahun 2024">PP Nomor 11 Tahun 2024</option>
                                <option value="PP Nomor 9 Tahun 2020">PP Nomor 9 Tahun 2020</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="masa_kerja_tahun" class="col-sm-3 col-form-label">Masa Kerja Tahun</label>
                        <div class="col-sm-9">
                            <select class="custom-select" name="masa_kerja_tahun">
                                <option selected disabled hidden>-Pilih-</option>
                                <?php for ($i = 1; $i <= 40; $i++) : ?>
                                    <option value=<?= $i; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gaji" class="col-sm-3 col-form-label">Gaji</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="gaji">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kgb_nomor_sk" class="col-sm-3 col-form-label">KGB Nomor SK</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kgb_nomor_sk">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kgb_tmt" class="col-sm-3 col-form-label">KGB TMT</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="kgb_tmt">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_yad_kgb" class="col-sm-3 col-form-label">KGB Tanggal YAD</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="tanggal_yad_kgb">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tahun_kgb" class="col-sm-3 col-form-label">Tahun KGB</label>
                        <div class="col-sm-9">
                            <select class="custom-select" name="tahun_kgb">
                                <?php $i = 1960; ?>
                                <option selected disabled hidden>-Pilih Tahun-</option>
                                <?php for ($i; $i <= date('Y'); $i++) : ?>
                                    <option value=<?= $i; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bulan_kgb" class="col-sm-3 col-form-label">Bulan KGB</label>
                        <div class="col-sm-9">
                            <select class="custom-select" name="bulan_kgb">
                                <option selected disabled hidden>-Pilih Bulan-</option>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kgb_tanggal_surat" class="col-sm-3 col-form-label">KGB Tanggal Surat</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="kgb_tanggal_surat">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_sk_terakhir" class="col-sm-3 col-form-label">Nomor SK Terakhir</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nomor_sk_terakhir">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="file_sk_berkala" class="col-sm-3 col-form-label">File SK Berkala</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file_sk_berkala" name="file_sk_berkala">
                                <label class="custom-file-label" for="file_sk_berkala">Choose file</label>
                            </div>
                            <?= form_error('file_sk_berkala', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="form_kgb">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->