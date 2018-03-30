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
    function __destruct() {

    }
}