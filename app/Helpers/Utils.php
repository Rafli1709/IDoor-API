<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Utils
{
    public function encryptBlowfish($plaintext, $key)
    {
        $filePath = public_path('scripts') . '/encrypt.py';
        $command = "python \"$filePath\" " . "\"$plaintext\" \"$key\"";
        $output = exec($command);

        return $output;
    }

    public function decryptBlowfish($ciphertext, $key)
    {
        $filePath = public_path('scripts') . '/decrypt.py';
        $command = "python \"$filePath\" " . "\"$ciphertext\" \"$key\"";
        $output = exec($command);

        return $output;
    }

    public function avalancheEffect($plaintext, $key)
    {
        $filePath = public_path('scripts') . '/avalance_effect.py';
        $command = "python \"$filePath\" " . "\"$plaintext\" \"$key\"";
        $output = exec($command);

        return $output;
    }

    public function convertDate($dateString)
    {
        $date = date_create_from_format('Y-m-d', $dateString);

        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $indonesianDate = date_format($date, 'j ') . $monthNames[(int)date_format($date, 'n')] . date_format($date, ' Y');
        return $indonesianDate;
    }
}
