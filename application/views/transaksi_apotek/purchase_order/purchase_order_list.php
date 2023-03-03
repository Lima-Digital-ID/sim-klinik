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
                <div class="box box-info box-solid">
                    <div class="box-header">
                        <h3 class="box-title">DAFTAR PURCHASE ORDER</h3>
                    </div>
                    <div class="box-body">
                        <form action="" method="get">
                            <div class="row">

                                <div class="col-md-2">
                                    <label for="">Supplier</label>
                                    <select name="supplier" id="" class="form-control select2">
                                        <option value="">---Pilih Supplier---</option>
                                        <?php foreach ($supplier as $key => $value) { ?>
                                            <option value="<?= $value->kode_supplier ?>" <?= $_GET['supplier'] == $value->kode_supplier ? 'selected' : '' ?>><?= $value->nama_supplier ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Jenis Pembayaran</label>
                                    <select name="jenis_bayar" id="" class="form-control select2">
                                        <option value="">---Pilih Jenis Pembayaran---</option>
                                        <option value="kredit" <?= $_GET['jenis_bayar'] == 'kredit' ? 'selected' : '' ?>>Kredit</option>
                                        <option value="cash" <?= $_GET['jenis_bayar'] == "cash" ? 'selected' : '' ?>>Cash</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Dari Tanggal</label>
                                    <input type="date" name="dari" class="form-control" value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Sampai Tanggal</label>
                                    <input type="date" name="sampai" class="form-control" value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>">
                                </div>
                                <br>
                                <button style="margin-top:4px" class="btn btn-danger mt-2"><span class="fa fa-search"></span> Tampilkan</button>
                            </div>
                            <div class="row">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6" style="text-align: end;">
                                    <br>
                                    <?php echo anchor(site_url('transaksi_apotek/create_po'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-success"'); ?>
                                </div>
                            </div>
                        </form>
                        <?php
                        if (isset($_GET['dari'])) {
                        ?>
                            <div style="padding-bottom: 10px;">
                                <div style="padding-bottom: 10px;">
                                </div>
                                <table class="table table-bordered table-striped" id="mytable">
                                    <thead>
                                        <tr>
                                            <th width="30px">No</th>
                                            <th>Nomor PO</th>
                                            <th>Nama Supplier</th>
                                            <th>Apoteker</th>
                                            <th>Total Harga</th>
                                            <th>Keterangan</th>
                                            <th>Jenis Pembayaran</th>
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
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <h3>Detail Obat</h3>
                <table class="table table-bordered table-striped" id="detailObat">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah PO</th>
                            <th>Diskon</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
                "url": "json_po?supplier=<?= $_GET['supplier'] ?>&dari=<?= $_GET['dari'] ?>&sampai=<?= $_GET['sampai'] ?>&jenis_bayar=<?= $_GET['jenis_bayar'] ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "kode_purchase",
                    "orderable": false
                }, {
                    "data": "kode_purchase"
                }, {
                    "data": "nama_supplier"
                }, {
                    "data": "nama_apoteker"
                },
                {
                    "render": function(data, type, row) {
                        return 'Rp. ' + formatRupiah(row.total_harga);
                    }
                }, {
                    "data": "keterangan"
                }, {
                    'render': function(data, type, row) {
                        return (row.jenis_pembayaran == 0 ? 'Cash' : 'Kredit');
                    }
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }
            ],
            order: [
                [0, 'asc']
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

    function cekDetail(id) {
        $('#myModal').show();
        // t = $('#detailObat').DataTable();
        // t.clear().draw(false);
        $('#detailObat td').remove();
        $.ajax({
            type: "GET",
            url: "<?= base_url('transaksi_apotek/json_detail_po/') ?>" + id, //json get site
            dataType: 'json',
            success: function(response) {
                arrData = response;
                $('#title').html('Purchase Order Nomor : ' + id)
                for (i = 0; i < arrData.length; i++) {
                    // t.row.add([
                    var table = '<tr><td><div class="text-center">' + arrData[i].kode_barang + '</div></td>' +
                        '<td><div class="text-center">' + arrData[i].nama_barang + '</div></td>' +
                        '<td><div class="text-left">Rp. ' + formatRupiah(arrData[i].harga) + '</div></td>' +
                        '<td><div class="text-left">' + arrData[i].jumlah + '</div></td>' +
                        '<td><div class="text-left">' + arrData[i].diskon + '</div></td></tr>';
                    $('#detailObat').append(table);
                    // ]).draw(false);
                }
            }
        });

    }

    function formatRupiah(angka, prefix) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }
</script>