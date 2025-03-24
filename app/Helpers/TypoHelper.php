<?php

namespace App\Helpers;

class TypoHelper
{
    /**
     * Fungsi untuk mencari bahan yang paling mendekati input user
     * menggunakan Levenshtein Distance.
     */
    public static function koreksiBahan($input, $bahanList)
    {
        $hasil = '';
        $jarak_terkecil = null;

        foreach ($bahanList as $bahan) {
            $jarak = levenshtein(strtolower($input), strtolower($bahan));

            error_log("Membandingkan: {$input} vs {$bahan}, Jarak: {$jarak}");

            if ($jarak < 3 && ($jarak_terkecil === null || $jarak < $jarak_terkecil)) {
                $jarak_terkecil = $jarak;
                $hasil = $bahan;
            }
        }

        return $hasil ?: $input; // Jika tidak ada yang cocok, kembalikan input awal
    }
}
