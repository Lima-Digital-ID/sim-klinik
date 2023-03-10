<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pendaftaran_model extends CI_Model
{

    public $table = 'tbl_pendaftaran';
    public $id = 'no_pendaftaran';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function get_next_antrian($id_dokter)
    {
        $this->db->where('id_dokter', $id_dokter);
        $this->db->where('is_periksa', 0);
        $this->db->order_by('dtm_crt', 'asc');
        return $this->db->get($this->table)->row();
    }

    function json($id_klinik = null)
    {
        // $id_klinik = $id_klinik != null ? $id_klinik : 0;

        $this->datatables->select('pd.no_pendaftaran,pd.no_rekam_medis,ps.no_id_pasien,ps.nama_lengkap as nama_pasien,k.nama as klinik,d.nama_dokter,pd.dtm_crt as tgl_pendaftaran,(CASE dd.no_pendaftaran WHEN pd.no_pendaftaran THEN "Dalam Proses" ELSE (CASE pd.is_periksa WHEN 0 THEN "Dalam Antrian" WHEN 3 THEN "Ditunda" END) END) as status, (CASE dd.no_pendaftaran WHEN pd.no_pendaftaran THEN "disabled" END) as status_antrian, (CASE u.id_klinik WHEN pd.id_klinik THEN "" ELSE "disabled" END)as status_dokter,(CASE d.is_jaga WHEN 1 THEN "" ELSE "disabled" END) as status_jaga,(CASE pd.is_periksa WHEN 3 THEN "disabled" END) as status_tunda');
        $this->datatables->from('tbl_pendaftaran pd');
        $this->datatables->join('tbl_pasien ps', 'pd.no_rekam_medis=ps.no_rekam_medis');
        $this->datatables->join('tbl_dokter d', 'pd.id_dokter=d.id_dokter');
        $this->datatables->join('tbl_dokter dd', 'pd.no_pendaftaran=dd.no_pendaftaran', 'left');
        $this->datatables->join('tbl_klinik k', 'pd.id_klinik = k.id_klinik');
        $this->datatables->join('tbl_user u', 'd.id_dokter=u.id_dokter', 'left');

        $this->datatables->where('pd.is_periksa=0 OR pd.is_periksa=3');

        if ($id_klinik != null)
            $this->datatables->where('pd.id_klinik', $id_klinik);

        $this->datatables->add_column('action', anchor(site_url('pendaftaran/periksa/$1'), 'Prioritas', 'class="btn btn-warning btn-sm $2 $3 $4"') . " " . anchor(site_url('pendaftaran/batal/$1'), 'Batal', 'class="btn btn-danger btn-sm $3 $4"') . " " . anchor(site_url('pendaftaran/tunda/$1'), 'Tunda', 'class="btn btn-default btn-sm $3 $4 $5"'), 'no_pendaftaran,status_antrian,status_dokter,status_jaga,status_tunda');

        return $this->datatables->generate();
    }

    function json2($id_klinik = null)
    {
        $this->datatables->select('pd.no_pendaftaran,pd.no_rekam_medis,ps.no_id_pasien,ps.nama_lengkap as nama_pasien,k.nama as klinik,d.nama_dokter,pd.dtm_crt as tgl_pendaftaran,(CASE pd.is_periksa WHEN 0 THEN "Dalam Antrian" WHEN 1 THEN "Selesai" WHEN 2 THEN "Dibatalkan" WHEN 3 THEN "Ditunda" END) as status, ps.alamat, ps.kabupaten');
        $this->datatables->from('tbl_pendaftaran pd');
        $this->datatables->join('tbl_pasien ps', 'pd.no_rekam_medis=ps.no_rekam_medis');
        $this->datatables->join('tbl_dokter d', 'pd.id_dokter=d.id_dokter');
        $this->datatables->join('tbl_klinik k', 'pd.id_klinik = k.id_klinik');
        $this->datatables->where('pd.is_periksa !=', 0);
        if ($id_klinik != null)
            $this->datatables->where('pd.id_klinik', $id_klinik);
        // $this->datatables->add_column('action',anchor(site_url('pembayaran/bayar/$1'),'Bayar','class="btn btn-danger btn-sm"'),'id_transaksi');

        return $this->datatables->generate();
    }

    function json_status_dokter($id_klinik = null)
    {
        $this->datatables->select('d.id_dokter,d.nama_dokter,(CASE d.is_jaga WHEN 1 THEN d.no_pendaftaran ELSE "-" END) as no_pendaftaran,(CASE d.is_jaga WHEN 0 THEN "Tidak Jaga" WHEN 1 THEN "Aktif" END) as status,(CASE d.is_jaga WHEN 1 THEN (SELECT count(*) FROM tbl_pendaftaran WHERE tbl_pendaftaran.id_dokter = d.id_dokter AND tbl_pendaftaran.is_periksa = 0 AND tbl_pendaftaran.id_klinik = u.id_klinik) ELSE "-" END) as sisa_antrian');
        $this->datatables->from('tbl_dokter d');
        $this->datatables->join('tbl_pendaftaran p', 'd.no_pendaftaran=p.no_pendaftaran', 'left');
        $this->datatables->join('tbl_user u', 'd.id_dokter=u.id_dokter', 'left');
        $this->datatables->join('tbl_klinik k', 'u.id_klinik=k.id_klinik', 'left');
        $this->datatables->where('is_jaga', 1);
        if ($id_klinik != null)
            $this->datatables->where('u.id_klinik', $id_klinik);
        // $this->datatables->add_column('action',anchor(site_url('pembayaran/bayar/$1'),'Bayar','class="btn btn-danger btn-sm"'),'id_transaksi');

        return $this->datatables->generate();
    }

    function json_status_dokter2()
    {
        $this->datatables->select('d.id_dokter,d.nama_dokter,(CASE d.is_jaga WHEN 1 THEN d.no_pendaftaran ELSE "-" END) as no_pendaftaran,(CASE d.is_jaga WHEN 0 THEN "Tidak Jaga" WHEN 1 THEN "Aktif" END) as status,k.nama as klinik, (CASE d.is_jaga WHEN 0 THEN "Aktifkan" WHEN 1 THEN "Nonaktifkan" END) as label_status, (CASE d.is_jaga WHEN 0 THEN "success" WHEN 1 THEN "danger" END) as style_status');
        $this->datatables->from('tbl_dokter d');
        $this->datatables->join('tbl_pendaftaran p', 'd.no_pendaftaran=p.no_pendaftaran', 'left');
        $this->datatables->join('tbl_user u', 'd.id_dokter=u.id_dokter', 'left');
        $this->datatables->join('tbl_klinik k', 'u.id_klinik=k.id_klinik', 'left');
        $this->datatables->add_column('action', anchor(site_url('pendaftaran/ubah_status_dokter/$1'), '$2', 'class="btn btn-$3 btn-sm"'), 'id_dokter,label_status,style_status');

        return $this->datatables->generate();
    }

    function json_antrian($id_dokter, $tipe, $isFormKhusus = false)
    {
        $this->datatables->select('pd.periksa_1,pr.no_periksa, pd.no_pendaftaran,pd.no_rekam_medis,ps.no_id_pasien,ps.nama_lengkap as nama_pasien,k.nama as klinik,d.nama_dokter,pd.dtm_crt as tgl_pendaftaran,(CASE dd.no_pendaftaran WHEN pd.no_pendaftaran THEN "Dalam Proses" ELSE (CASE pd.is_periksa WHEN 0 THEN "Dalam Antrian" END) END) as status, (CASE dd.no_pendaftaran WHEN pd.no_pendaftaran THEN "disabled" END) as status_antrian,tipe_periksa,  tjp.name as tujuan_periksa, pd.id_tujuan_periksa');
        $this->datatables->from('tbl_pendaftaran pd');
        $this->datatables->join('tbl_pasien ps', 'pd.no_rekam_medis=ps.no_rekam_medis');
        $this->datatables->join('tbl_dokter d', 'pd.id_dokter=d.id_dokter');
        $this->datatables->join('tbl_dokter dd', 'pd.no_pendaftaran=dd.no_pendaftaran', 'left');
        $this->datatables->join('tbl_periksa pr', 'pd.no_pendaftaran=pr.no_pendaftaran', 'left');
        $this->datatables->join('tbl_klinik k', 'pd.id_klinik = k.id_klinik');
        $this->datatables->join('tbl_tujuan_periksa tjp', 'pd.id_tujuan_periksa = tjp.id');
        $whereDokter = $id_dokter ? " and pd.id_dokter = '$id_dokter'" : '';
        $where = "pd.is_periksa = '0' $whereDokter ";
        // $this->datatables->where('pd.is_periksa', 0);
        // $this->datatables->where('pd.id_dokter', $id_dokter);
        if ($tipe == 1 || $tipe == 4) {
            $where .= "and pd.tipe_periksa = '1' or $where and pd.tipe_periksa = '4' ";
            // $this->datatables->where('pd.tipe_periksa', '1');
            // $this->datatables->or_where('pd.tipe_periksa', '4');
        } else {
            $where .= "and pd.tipe_periksa = '$tipe'";
            // $this->datatables->where('pd.tipe_periksa', $tipe);
        }
        $this->datatables->where($where);

        $this->datatables->add_column('option', "<select data-no='$1' class='form-control optionList'>
        <option value='1'>Surat Rujukan</option><option value='2'>Blanko Resep</option><option value='3'>Kartu Pasien</option></select>", 'no_pendaftaran');

        if ($isFormKhusus) {
            $this->datatables->add_column('action', anchor(site_url('form_khusus/preview/$1?act=preview'), 'Preview', 'class="btn btn-warning btn-sm btn-act" data-no="$1" data-form="1"') . " " . anchor(site_url('form_khusus/preview/$1?act=doc'), 'Download Doc', 'class="btn btn-primary btn-sm btn-act" data-no="$1" data-form="1"') . " " . anchor(site_url('form_khusus/preview/$1?act=print'), 'Print', 'class="btn btn-success btn-sm btn-act" data-no="$1" data-form="1"'), 'no_pendaftaran');
        } else {
            $textPeriksa = $id_dokter ? 'Periksa Dokter' : 'Periksa Perawat'; 
            $this->datatables->add_column('action', anchor(site_url('periksamedis/periksa/$1?tipe=$3'), $textPeriksa, 'class="btn btn-warning btn-sm $2"'), 'no_pendaftaran,status_antrian,tipe_periksa');
            
            $this->datatables->add_column('action_edit', anchor(site_url('periksamedis/edit?id=$1'), $textPeriksa, 'class="btn btn-warning btn-sm"'), 'no_periksa');
            $this->datatables->add_column('rapid', anchor(site_url('periksamedis/edit?id=$1'), 'Rapid', 'class="btn btn-success btn-sm"'), 'no_periksa');
            $this->datatables->add_column('sksehat', anchor(site_url('periksamedis/sksehat?id=$1'), 'Surat Sehat', 'class="btn btn-info btn-sm"'), 'no_rekam_medis');
        }

        return $this->datatables->generate();
    }

    // function json_pencarian(){
    //     $this->datatables->select('p.no_rekam_medis,p.nik,p.no_id_pasien,p.nama_lengkap as nama_pasien,p.tanggal_lahir, p.nomer_telepon as no_hp');
    //     $this->datatables->from('tbl_pasien p');
    //     $this->datatables->add_column('action',anchor(site_url('pendaftaran/existing/$1'),'Daftarkan','class="btn btn-warning btn-sm"'),'no_rekam_medis');

    //     return $this->datatables->generate();
    // }

    // function json_pencarian_by_dokter(){
    //     $this->datatables->select('p.no_rekam_medis,p.nik,p.no_id_pasien,p.nama_lengkap as nama_pasien,p.tanggal_lahir, p.nomer_telepon as no_hp');
    //     $this->datatables->from('tbl_pasien p');
    //     $this->datatables->add_column('action',anchor(site_url('periksamedis/existing/$1'),'Daftarkan','class="btn btn-warning btn-sm"'),'no_rekam_medis');

    //     $this->datatables->add_column('action', anchor(site_url('periksamedis/periksa/$1?tipe=$3'), 'Periksa Dokter', 'class="btn btn-warning btn-sm $2"'), 'no_pendaftaran,status_antrian,tipe_periksa');

    //     return $this->datatables->generate();
    // }

    function json_pencarian()
    {
        $this->datatables->select('p.no_rekam_medis,p.nik,p.no_id_pasien,p.nama_lengkap as nama_pasien,p.tanggal_lahir, p.nomer_telepon as no_hp, p.alamat, p.kabupaten');
        $this->datatables->from('tbl_pasien p');
        $this->datatables->add_column('action', anchor(site_url('pendaftaran/existing/$1'), 'Daftarkan', 'class="btn btn-warning btn-sm"') . " " . anchor('#', 'Detail', "class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onClick='javasciprt: cekDetail(\"$1\")'"), 'no_rekam_medis');

        return $this->datatables->generate();
    }

    function json_pencarian_by_dokter()
    {
        $this->datatables->select('p.no_rekam_medis,p.nik,p.no_id_pasien,p.nama_lengkap as nama_pasien,p.tanggal_lahir, p.nomer_telepon as no_hp');
        $this->datatables->from('tbl_pasien p');
        $this->datatables->add_column('action', anchor(site_url('periksamedis/existing/$1'), 'Daftarkan', 'class="btn btn-warning btn-sm"'), 'no_rekam_medis');

        return $this->datatables->generate();
    }

    function cekkodependaftaran()
    {
        $query = $this->db->query("SELECT MAX(no_pendaftaran) as np from tbl_pendaftaran");
        $hasil = $query->row();
        return $hasil->np;
    }

    function get_all_tujuan()
    {
        $this->db->order_by('id', $this->order);
        return $this->db->get('tbl_tujuan_periksa')->result();
    }

    function get_id_tujuan($id)
    {        
        $this->db->where('id', $id);
        return $this->db->get('tbl_tujuan_periksa')->row();
    }

    function berat_badan($id)
    {
        $this->db->order_by('id_periksa_d_fisik', $this->order);
        $this->db->limit(1);
        $this->db->where('no_periksa', $id);
        $this->db->where('nama_periksa_fisik', 'Berat Badan');
        return $this->db->get('tbl_periksa_d_fisik')->result();
    }

    function tinggi_badan($id)
    {
        $this->db->order_by('id_periksa_d_fisik', $this->order);
        $this->db->limit(1);
        $this->db->where('no_periksa', $id);
        $this->db->where('nama_periksa_fisik', 'Tinggi Badan');
        return $this->db->get('tbl_periksa_d_fisik')->result();
    }
}
