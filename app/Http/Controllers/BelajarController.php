<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BelajarController extends Controller
{
    public function enkripsi(Request $request)
    {
        $string   = "Saya suka makan sate";
        $enkripsi = Crypt::encryptString($string);
        $deskripsi = Crypt::decryptString($enkripsi);

        echo "String : " . $string . "<br><br>";
        echo "Hasil Enkripsi : " . $enkripsi . "<br><br>";
        echo "Hasil Dekripsi : " . $deskripsi;

        $params = [
            'nama' => 'egy gynanjar',
            'hobby' => 'Mendengar Musik',
            'makanan_favorit' => 'Sate',
        ];

        $params = Crypt::encrypt($params);

        echo "<a href=" . route('enkripsi-detail', ['params' => $params]) . ">Lihat detail disini</a>";
    }

    public function enkripsi_detail(Request $request, $params)
    {
        $params = Crypt::decrypt($params);

        dd($params);
    }
}
