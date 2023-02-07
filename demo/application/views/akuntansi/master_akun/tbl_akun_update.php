<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">BUAT KODE AKUN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                        <br>
                            <div class="col-sm-2">
                                <label>Nama Akun</label>    
                            </div>
                            <div class="col-sm-10">
                                <input class="form-control" name="nama_akun" required  value="<?=$nama_akun?>">
                            </div>
                        </div> 
                        <div class="col-sm-12">
                        <br>
                            <div class="col-sm-2">
                                <label>Kode Akun</label>    
                            </div>
                            <div class="col-sm-10">
                                <input class="form-control" name="id_akun" type="hidden" value="<?=$id_akun?>">
                                <input class="form-control" name="no_akun" id="no_akun" required readonly="" value="<?=$no_akun?>">
                            </div>
                        </div> 
                        <div class="col-sm-12">
                        <br>
                            <div class="col-sm-2">
                                
                            </div>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                                <a href="<?php echo site_url('akuntansi/akun') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                            </div>
                        </div> 
                    </div>
                </div>
            </form>        
        </div>
    </section>
</div>
<script type="text/javascript">
    var level=1;

    function setLevel(){
        level=parseInt($('#level').val());
        if (level == 0) {
            $('#parent').hide();
            $('#level2').hide();
            $('#level3').hide();
            $('#kode_parent').val('');
        }else if(level == 1){
            $('#parent').show();
            $('#level2').hide();
            $('#level3').hide();
            $('#kode_parent').val('');
            $('#sublevel1').empty();
        }else if(level == 2){
            $('#parent').show();
            $('#level2').show();
            $('#level3').hide();
            $('#kode_parent').val('');
            $('#sublevel2').empty();
        }else if(level == 3){
            $('#parent').show();
            $('#level2').show();
            $('#level3').show();
            $('#kode_parent').val('');
        }
    }
    var id_parent=0;
    function cekParent(){
        var id=$('#id_parent').val();
        if (level == 1) {
            cekKodeAkun(id);
        }else if(level > 1){
            $('#sublevel1').empty();
            var subAkun=$('#sublevel1');
            $.ajax({
                url : 'getLevel/'+id, 
                type : 'GET',
                dataType : 'json',
                success: function(response){
                    // console.log(response);
                    arrData=response;
                    var option = '<option value="">Pilih Akun</option>';
                    for (var i = 0; i < arrData.length; i++) {
                        option+='<option value="'+arrData[i]['id_akun']+'">'+arrData[i]['nama_akun']+'</option>';
                    }
                    subAkun.append(option);
                }
            });
        }
        var parent=<?=$parent_option_js?>;
        for (var i = 0; i < parent.length; i++) {
            if (parent[i]['label'] == id) {
                id_parent=parent[i]['value'];
            }
        }
    }
    function cekSubLevel1(){
        var id=$('#sublevel1').val();
        if (level == 2) {
            cekKodeAkun(id);
        }else if(level > 2){
            $('#sublevel2').empty();
            var subAkun=$('#sublevel2');
            $.ajax({
                url : 'getLevel/'+id, 
                type : 'GET',
                dataType : 'json',
                success: function(response){
                    // console.log(response);
                    arrData=response;
                    var option = '<option value="">Pilih Akun</option>';
                    for (var i = 0; i < arrData.length; i++) {
                        option+='<option value="'+arrData[i]['id_akun']+'">'+arrData[i]['nama_akun']+'</option>';
                    }
                    console.log(option);
                    subAkun.append(option);
                }
            });
        }
    }
    function cekSubLevel2(){
        var id=$('#sublevel2').val();
        if (level == 3) {
            cekKodeAkun(id);
        }
    }
    var dataAkun=0;
    function cekKodeAkun(id){
        $.ajax({
            url : 'getNoAkun/'+id, 
            type : 'GET',
            dataType : 'json',
            success: function(response){
                dataAkun=response;
                var nomor=pecahAkun(dataAkun['no_akun']);
                if (level == 1) {
                    var iterate=parseInt(nomor[1])+1;
                    $('#no_akun').val(dataAkun['no_akun_main']+'.'+iterate+'.0.0');
                }else if (level == 2) {
                    var iterate=parseInt(nomor[2])+1;
                    var pecah=dataAkun['no_akun_main'].split('.');
                    $('#no_akun').val(pecah[0]+'.'+pecah[1]+'.'+iterate+'.0');
                }
                else if (level == 3) {
                    var iterate=parseInt(nomor[3])+1;
                    var pecah=dataAkun['no_akun_main'].split('.');
                    $('#no_akun').val(pecah[0]+'.'+pecah[1]+'.'+pecah[2]+'.'+iterate);
                }
            }
        });
    }

    function pecahAkun(val){
        if (val != null) {
            var a=val.split('.');
        }else{
            var a=[0,0,0,0];
        }
        return a;
    }
</script>