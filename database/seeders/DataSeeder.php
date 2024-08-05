<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\User;
use App\Helpers\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'profile' => [
                    'no_hp' => '081212121212',
                    'jenis_kelamin' => 'Laki-Laki',
                    'tgl_lahir' => '2001-10-02',
                    'alamat' => 'Jl. Admin',
                ]
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'profile' => [
                    'no_hp' => '081313131313',
                    'jenis_kelamin' => 'Perempuan',
                    'tgl_lahir' => '2002-10-01',
                    'alamat' => 'Jl. User',
                ]
            ],
        ];

        foreach ($users as $user) {
            $newUser = User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role' => $user['role'],
            ]);

            $newUser->profile()->create($user['profile']);

            if ($user['role'] == 'user') {
                for ($i = 1; $i <= 10; $i++) {
                    $temp = User::create([
                        'name' => $user['name'] . " $i",
                        'username' => $user['username'] . $i,
                        'email' => "user$i@gmail.com",
                        'password' => $user['password'],
                        'role' => $user['role'],
                    ]);

                    $temp->profile()->create($user['profile']);
                }
            }
        }

        $utils = new Utils();

        $alat1 = Alat::create([
            'user_id' => 2,
            'nama' => "Alat 1",
            'secret_key' => "Alat 1",
            'imei' => "000000000000001"
        ]);

        $encryptedText = $utils->encryptBlowfish($alat1->secret_key, $alat1->imei);
        $alat1->update(['password' => $encryptedText]);

        $alat2 = Alat::create([
            'user_id' => 2,
            'nama' => "Alat 2",
            'secret_key' => "Alat 2",
            'imei' => "000000000000002"
        ]);

        $encryptedText = $utils->encryptBlowfish($alat2->secret_key, $alat2->imei);
        $alat2->update(['password' => $encryptedText]);

        for ($i = 1; $i <= 10; $i++) {
            $no = $i + 2;
            $temp = Alat::create([
                'user_id' => $i + 1,
                'nama' => "Alat $no",
                'secret_key' => "Alat $no",
                'imei' => "0000000000000$no"
            ]);

            $encryptedText = $utils->encryptBlowfish($temp->secret_key, $temp->imei);
            $temp->update(['password' => $encryptedText]);
        }
    }
}
