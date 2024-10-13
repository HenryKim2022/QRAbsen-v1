<?php

namespace Database\Seeders;

use App\Models\TheApp_Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tb_SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settingsList = [
            [
                'na_setting' => 'CompanyName',
                'text_setting' => 'PT. XYZ',
                'status_setting' => 1,
                'url_setting' => env('APP_URL'),
            ],
            [
                'na_setting' => 'CompanyAddress',
                'text_setting' => "Bintaro Utama 9 JB1 No. 10
                Kota Tangerang Selatan
                Banten 15229",
                'status_setting' => 1,
                'url_setting' => env('APP_URL'),
            ],
            [
                'na_setting' => 'CompanyPhone',
                'text_setting' => "+62 888-1-400-400",
                'status_setting' => 1,
                'url_setting' => env('APP_URL'),
            ],
            [
                'na_setting' => 'CompanyEmail',
                'text_setting' => "sales@fahove.com",
                'status_setting' => 1,
                'url_setting' => env('APP_URL'),
            ],
            [
                'na_setting' => 'SiteBrand',
                'text_setting' => 'PT. XYZ',
                'status_setting' => 1,
                'url_setting' => '',
            ],
            [
                'na_setting' => 'SiteCopyrightYear',
                'text_setting' => '2024',
                'status_setting' => 1,
                'url_setting' => '',
            ],
            [
                'na_setting' => 'AboutUSText',
                'text_setting' => "Kami adalah perusahaan IT yang berkomitmen menyediakan solusi teknologi terdepan untuk memenuhi kebutuhan dan tantangan bisnis Anda.",
                'status_setting' => 1,
                'url_setting' => '',
            ],
        ];

        foreach ($settingsList as $setting) {
            $existingSetting = TheApp_Model::where('na_setting', $setting['na_setting'])->first();
            if ($existingSetting) {
                $existingSetting->update($setting);
            } else {
                TheApp_Model::create($setting);
            }
        }
    }
}
