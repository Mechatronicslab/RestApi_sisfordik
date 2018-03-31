<?php

/**
 * Created by PhpStorm.
 * User: Terminator
 * Date: 30/03/2018
 * Time: 16:00
 */
class DB_Function_Keuangan
{
    private $conn;
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // koneksi ke database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {}

    public function getDataNikKaryawan()
    {
        /* check connection */
        $query = $this->conn->query("SELECT nama,nik FROM m_karyawan");
        $myArray = array();
        while ($row = $query->fetch_object()) {
            $tempArray = $row;
            array_push($myArray, $tempArray);
        }

        if ($myArray != NULL) {
            echo json_encode(array('error' => FALSE, 'result' => $myArray));

        } else {

            echo json_encode(array('error' => TRUE, 'result' =>'Terjadi Kesalahan'));
        }
        /* free result set */
        $query->close();

        /* close connection */
        $this->conn->close();
        return $query;
    }

    public function getNik($nik) {
        $stmt = $this->conn->prepare("SELECT * FROM m_karyawan WHERE nik = '$nik'");
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    public function inputGajihKaryawan($nik,$nama,$pendidikan,$jabatan,$masaKerja,$gajihpokok,$tunJabatan,$tunLain,$potongan,$totalGajih,$jumlahPinjam,$jumlahPotongan,$sisaPinjaman,$gajihBersih) {
        $stmt = $this->conn->prepare("INSERT INTO `t_gaji`(nik, `nama`, `pendidikan`, `jabatan`, `masa_kerja`, `gaji_pokok`, `tunjangan_jabatan`,
                  `tunjangan_lainya`, `potongan`, `total_gaji`, `jmlah_pinjaman`, `jmlah_potongan`, `sisa_pinjaman`, `gaji_bersih`, `tgl_input`) VALUES
                  ('$nik','$nama','$pendidikan','$jabatan','$masaKerja','$gajihpokok','$tunJabatan','$tunLain','$potongan','$totalGajih','$jumlahPinjam','$jumlahPotongan','$sisaPinjaman','$gajihBersih',NOW())");
        if ($stmt->execute()) {
            //$user = $stmt->get_result()->fetch_assoc();
            //$stmt->close();
            return $stmt;
        } else {
            return NULL;
        }
    }
}