<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            <?php 
            if($this->session->flashdata('message')){
                if($this->session->flashdata('message_type') == 'danger')
                    echo alert('alert-danger', 'Perhatian', $this->session->flashdata('message'));
                else if($this->session->flashdata('message_type') == 'success')
                    echo alert('alert-success', 'Sukses', $this->session->flashdata('message')); 
                else
                    echo alert('alert-info', 'Info', $this->session->flashdata('message')); 
            }
            ?>
            </div>
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Khusus</h3>
                    </div>
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#medis">Form Khusus</a></li>
                        </ul>
                        <br>
                        <div class="tab-content">
                            <div id="medis" class="tab-pane fade in active">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="mytable">
                                        <thead>
                                            <tr>
                                                <th width="30px">No</th>
                                                <th>No Pendaftaran</th>
                                                <th>Nama Pasien</th>
                                                <th>Klinik</th>
                                                <th>Nama Dokter</th>
                                                <th>Tgl Pendaftaran</th>
                                                <th>Form</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
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
            ajax: {"url": "periksamedis/json_antrian/1/true", "type": "POST"},
            columns: [
                {
                    "data": "no_pendaftaran",
                    "orderable": false
                },{"data": "no_pendaftaran"},{"data": "nama_pasien"},{"data": "klinik"},{"data": "nama_dokter"},{"data": "tgl_pendaftaran"},
                {
                    "data": "option",
                    "orderable": false,
                    "className" : "text-center"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        $("#mytable tbody").on('change','.optionList', function(){
            var thisVal = $(this).val()
            var noDaftar = $(this).data('no')
            $(".btn-act[data-no='"+noDaftar+"']").attr('data-form',thisVal)
        })

        $("#mytable tbody").on('click','.btn-act', function(e){
            e.preventDefault();
            
            var href = $(this).attr('href')
            var form = $(this).attr('data-form')

            window.location = href+"&form="+form
        })

    });
</script>
