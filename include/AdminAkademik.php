<?php

/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 3/24/2018
 * Time: 6:37 AM
 */
define('UPLOAD_PATH', 'foto/');
class AdminAkademik
{

    private $conn;

    // constructor
    function __construct()
    {
        require_once 'DB_Connect.php';
        // koneksi ke database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct()
    {

    }


    public function InsertKaryawan($nama,$nik,$nuptk,$tmpt_lahir,$tgl_lahir,$kelamin,$pend_terakhir,$tmt,
                                    $jabatan,$status,$sertifikasi,$alamat) {
        $stmt = $this->conn->prepare("INSERT INTO m_karyawan(nama,nik,nuptk,tmpt_lahir,tgl_lahir,j_kelamin,pend_terakhir,mulai_tugas
            ,jabatan,status,sertifikasi,alamat) VALUES ('$nama','$nik','$nuptk','$tmpt_lahir','$tgl_lahir','$kelamin','$pend_terakhir'
            ,'$tmt','$jabatan','$status','$sertifikasi','$alamat')");
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return NULL;
        }
    }

    public function DeleteKaryawan($nik) {
        $stmt = $this->conn->query("DELETE FROM m_karyawan WHERE nik='$nik'");
        if ($stmt!=False) {
            return $stmt;
        } else {
            return NULL;
        }
    }

    public function ShowKaryawan()
    {
        /* check connection */
        $query = "SELECT * FROM m_karyawan";
        
        $result = $this->conn->query($query);
        $myArray = array();
        $num_rows = mysqli_num_rows($result);
        while ($row = $result->fetch_object()) {
            $tempArray = $row;
            array_push($myArray, $tempArray);
        }

        if ($myArray != NULL) {
            echo json_encode(array('error' => FALSE,'jml_data'=>$num_rows+1 ,'result' => $myArray));

        } else {

            echo json_encode(array('error' => 'Data Tidak Ada'));
        }
        /* free result set */
        $result->close();

        /* close connection */
        $this->conn->close();
        return $result;
    }

    public function KaryawanGetById($nik)
    {
        /* check connection */
        $query = $this->conn->query("SELECT * FROM m_karyawan where nik = '$nik'");
        $myArray = array();
        while ($row = $query->fetch_object()) {
            $tempArray = $row;
            array_push($myArray, $tempArray);
        }

        if ($myArray != NULL) {
            echo json_encode(array('error' => FALSE, 'result' => $myArray));

        } else {

            echo json_encode(array('error_msg' => 'Terjadi Kesalahan'));
        }
        /* free result set */
        $query->close();

        /* close connection */
        $this->conn->close();
        return $query;
    }

    public function UpdateKaryawan($DataJson)
    {

        $data = json_decode($DataJson, true);
        foreach ($data['data'] as $object) {
            $id = $object['id'];
            $nik = $object['nik'];
            $nama = $object['nama'];
            $nuptk = $object['nuptk'];
            $tmpt_lahir = $object['tmpt_lahir'];
            $tgl_lahir = $object['tgl_lahir'];
            $kelamin = $object['kelamin'];
            $pend_terakhir = $object['pend_terakhir'];
            $tmt = $object['mulai_tugas'];
            $jabatan = $object['jabatan'];
            $status = $object['status'];
            $sertifikasi = $object['sertifikasi'];
            $alamat = $object['alamat'];
            $stmt = $this->conn->query("UPDATE `m_karyawan` SET `nama`='$nama',`nik`='$nik',`nuptk`='$nuptk',
                                            `tmpt_lahir`='$tmpt_lahir',`tgl_lahir`='$tgl_lahir',`j_kelamin`='$kelamin',
                                            `pend_terakhir`='$pend_terakhir',`mulai_tugas`='$tmt',`jabatan`='$jabatan',
                                            `status`='$status',`sertifikasi`='$sertifikasi',`alamat`='$alamat'
                                          WHERE id='$id'");
            if ($stmt != False) {
                //move_uploaded_file($_FILES['pic']['tmp_name'], UPLOAD_PATH . $foto);
                //$stmt->bind_param("ss", $foto,$tag);
                echo json_encode(array('error' => FALSE, 'message' => "Data Berhasil Disimpan"));
                return $stmt;
            } else {
                echo json_encode(array('error_msg' => "Data Gagal Diubah"));
                return NULL;
            }

        }

    }

    public function uploadImage($id,$foto)
    {
        $response = array();
        $stmt = $this->conn->query("Update `m_karyawan` SET `foto`='$foto' WHERE id ='$id'");
        if ($stmt!=False) {
            move_uploaded_file($_FILES['pic']['tmp_name'], UPLOAD_PATH . $foto);
            echo json_encode(array('error' => FALSE, 'message' => "Foto Berhasil Diupload"));
        } else {
            throw new Exception("Could not upload file");
        }
    }
//=========================Data Pelajaran=======================================================
    public function InsertMapel($kd_mapel,$nama_mapel)
    {
        $stmt = $this->conn->prepare("INSERT INTO tb_mapel(kd_mapel,nama_mapel) VALUES ('$kd_mapel','$nama_mapel')");
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return NULL;
        }
    }

     public function DeleteMapel($kd_mapel) {
        $stmt = $this->conn->query("DELETE FROM tb_mapel WHERE kd_mapel='$kd_mapel'");
        if ($stmt!=False) {
            return $stmt;
        } else {
            return NULL;
        }
    }

    public function ShowMapel()
    {
        /* check connection */
        $query = "SELECT kd_mapel,nama_mapel FROM tb_mapel";
        $result = $this->conn->query($query);
        $myArray = array();
        while ($row = $result->fetch_object()) {
            $tempArray = $row;
            array_push($myArray, $tempArray);
        }

        if ($myArray != NULL) {
            echo json_encode(array('error' => FALSE, 'result' => $myArray));

        } else {

            echo json_encode(array('error' => 'Data Tidak Ada'));
        }
        /* free result set */
        $result->close();

        /* close connection */
        $this->conn->close();
        return $result;
    }

    public function MapelGetById($kd_mapel)
    {
        /* check connection */
        $query = $this->conn->query("SELECT * FROM tb_mapel where kd_mapel = '$kd_mapel'");
        $myArray = array();
        while ($row = $query->fetch_object()) {
            $tempArray = $row;
            array_push($myArray, $tempArray);
        }

        if ($myArray != NULL) {
            echo json_encode(array('error' => FALSE, 'result' => $myArray));

        } else {

            echo json_encode(array('error_msg' => 'Terjadi Kesalahan'));
        }
        /* free result set */
        $query->close();

        /* close connection */
        $this->conn->close();
        return $query;
    }

    public function UpdateMapel($id,$kd_mapel,$nama_mapel)
    {
       $stmt = $this->conn->prepare("UPDATE `tb_mapel` SET `kd_mapel`='$kd_mapel',`nama_mapel`='$nama_mapel' WHERE id='$id'");
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return NULL;
        }
    }




//=========================fungsi Cek ===========================================================
    public function cekKdMapel($kd_mapel) {
        $stmt = $this->conn->prepare("SELECT kd_mapel FROM tb_mapel WHERE kd_mapel = '$kd_mapel'");
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
    public function cekNik($nik) {
        $stmt = $this->conn->prepare("SELECT * FROM m_karyawan WHERE nik = '$nik'");
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
}