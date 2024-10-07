<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParsingDataController extends Controller
{
    public function parseData($nama_lengkap, $email, $jenis_kelamin)
    {
        // Menampilkan data yang diparsing dari route
        return "Nama Lengkap: $nama_lengkap, Email: $email, Jenis Kelamin: $jenis_kelamin";
    }
}
