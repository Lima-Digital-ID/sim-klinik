<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">POS OBAT</h3>
                    </div>

                    <div class="box-body">
                        <form action="" id="" method="get">
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="">Dari Tanggal</label>
                                    <input type="date" name="dari" class="form-control" value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>" >
                                </div>
                                <div class="col-md-6">
                                    <label for="">Sampai Tanggal</label>
                                    <input type="date" name="sampai" class="form-control" value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <br>
                                    <button class="btn btn-danger"><span class="fa fa-search"></span> Tampilkan</button>
                                </div>
                                <div class="col-md-6" style="text-align: end;">
                                    <br>
                                    <a href="<?php echo base_url() ?>kasir/jual_obat" class="btn btn-success"><span class="fa fa-plus"></span> Tambah</a>
                                </div>
                            </div>
                    </form>
                        <?php 
                            if(isset($_GET['dari'])){
                        ?>
                        <div style="padding-bottom: 10px;">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Nomor Transaksi</th>
                                    <th>Nama Pembeli</th>
                                    <th>Tanggal Beli Obat</th>
                                    <!-- <th>Status Pembayaran</th> -->
                                    <th>Total</th>
                                    <th width="150px">Action</th>
                                </tr>
                            </thead>
                        </table>
                        <?php
                        }
                        ?>
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
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
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
            ajax: {"url": "json_obat3?dari=<?php echo $_GET['dari'].'&sampai='.$_GET['sampai'];?>", "type": "POST"},
            columns: [
                {
                    "data": "tgl_bayar",
                    "orderable": false
                },
                {
                    "data": "no_transaksi",
                    "orderable": false
                },
                {
                    "data": "atas_nama",
                    "orderable": false
                },
                {
                    "data": "tgl_beli",
                    "orderable": false
                },
                {
                    "data": "tgl_beli",
                    "orderable": false
                },
                {
                    "data": "action",
                    "orderable": false
                },
            ],
            // order: [[4, 'asc']],
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