<?php

namespace Database\Seeders;

use App\Models\DaftarLogin_Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tb_DaftarLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loginList = [
            ['admin', 'admin@mail.com', '123456', 1],
            ['karyawan1', 'karyawan@mail.com', '123456', 2],
        ]; // Example userlogin values

        foreach ($loginList as $index => $login) {
            $username = $login[0];
            $email = $login[1];
            $password = $login[2];
            $userType = $login[3];

            $existingUser = DaftarLogin_Model::where('username', $username)->first();

            if ($existingUser) {
                $existingUser->update([
                    'email' => $email,
                    'password' => bcrypt($password),
                    'type' => $userType,
                    'id_karyawan' => $index + 1
                ]);
            } else {
                DaftarLogin_Model::create([
                    'username' => $username,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'type' => $userType,
                    'id_karyawan' => $index + 1
                ]);
            }
        }
    }
}
