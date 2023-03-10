<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($this->session->flashdata('message')) {
                    if ($this->session->flashdata('message_type') == 'danger')
                        echo alert('alert-danger', 'Perhatian', $this->session->flashdata('message'));
                    else if ($this->session->flashdata('message_type') == 'success')
                        echo alert('alert-success', 'Sukses', $this->session->flashdata('message'));
                    else
                        echo alert('alert-info', 'Info', $this->session->flashdata('message'));
                }
                ?>
            </div>
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">ANTRIAN PENDAFTARAN</h3>
                    </div>

                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>No Pendaftaran</th>
                                    <th>No Rekam Medis</th>
                                    <th>No ID Pasien</th>
                                    <th>Nama Pasien</th>
                                    <th>Klinik</th>
                                    <th>Nama Dokter</th>
                                    <th>Tgl Pendaftaran</th>
                                    <th>Status</th>
                                    <th width="180px">Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">RIWAYAT PENDAFTARAN</h3>
                    </div>

                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <table class="table table-bordered table-striped" id="mytable2">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>No Pendaftaran</th>
                                    <th>No Rekam Medis</th>
                                    <!-- <th>No ID Pasien</th> -->
                                    <th>Nama Pasien</th>
                                    <th>Alamat</th>
                                    <th>Nama Dokter</th>
                                    <th>Tgl Pendaftaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        var t = $("#mytable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode == 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "pendaftaran/json",
                "type": "POST"
            },
            columns: [{
                    "data": "no_pendaftaran",
                    "orderable": false
                }, {
                    "data": "no_pendaftaran"
                }, {
                    "data": "no_rekam_medis"
                }, {
                    "data": "no_id_pasien"
                }, {
                    "data": "nama_pasien"
                }, {
                    "data": "klinik"
                }, {
                    "data": "nama_dokter"
                }, {
                    "data": "tgl_pendaftaran"
                }, {
                    "data": "status"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }

            ],
            order: [
                [7, 'asc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        var t2 = $("#mytable2").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable2_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode == 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "pendaftaran/json2",
                "type": "POST"
            },
            columns: [{
                    "data": "no_pendaftaran",
                    "orderable": false
                }, {
                    "data": "no_pendaftaran"
                }, {
                    "data": "no_rekam_medis"
                }, {
                    "data": "nama_pasien"
                }, {
                    "data": "alamat",
                    "render": function(data, type, row) {
                        return row.alamat + ', ' + row.kabupaten
                    }
                }, {
                    "data": "nama_dokter"
                }, {
                    "data": "tgl_pendaftaran"
                }, {
                    "data": "status"
                }

            ],
            order: [
                [7, 'asc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

    });
</script>