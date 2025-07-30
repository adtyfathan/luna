<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universitas = [
            'Universitas Indonesia',
            'Institut Teknologi Bandung',
            'Universitas Gadjah Mada',
            'Institut Pertanian Bogor',
            'Institut Teknologi Sepuluh Nopember',
            'Universitas Airlangga',
            'Universitas Padjadjaran',
            'Universitas Brawijaya',
            'Universitas Diponegoro',
            'Universitas Sebelas Maret',
            'Universitas Negeri Yogyakarta',
            'Universitas Negeri Jakarta',
            'Universitas Negeri Malang',
            'Universitas Negeri Semarang',
            'Universitas Andalas',
            'Universitas Sumatera Utara',
            'Universitas Hasanuddin',
            'Universitas Riau',
            'Universitas Jambi',
            'Universitas Sriwijaya',
            'Universitas Lampung',
            'Universitas Tanjungpura',
            'Universitas Mulawarman',
            'Universitas Lambung Mangkurat',
            'Universitas Mataram',
            'Universitas Udayana',
            'Universitas Syiah Kuala',
            'Universitas Bengkulu',
            'Universitas Tadulako',
            'Universitas Sam Ratulangi',
            'Universitas Halu Oleo',
            'Universitas Papua',
            'Universitas Cenderawasih',
            'Universitas Negeri Makassar',
            'Universitas Pendidikan Indonesia',
            'Universitas Islam Negeri Syarif Hidayatullah Jakarta',
            'Universitas Islam Negeri Sunan Kalijaga Yogyakarta',
            'Universitas Islam Negeri Maulana Malik Ibrahim Malang',
            'Universitas Islam Negeri Sunan Gunung Djati Bandung',
            'Universitas Islam Negeri Alauddin Makassar',
            'Universitas Negeri Surabaya',
            'Universitas Trunojoyo Madura',
            'Universitas Pembangunan Nasional "Veteran" Yogyakarta',
            'Universitas Pembangunan Nasional "Veteran" Jakarta',
            'Universitas Pembangunan Nasional "Veteran" Jawa Timur',
            'Universitas Sultan Ageng Tirtayasa',
            'Universitas Siliwangi',
            'Universitas Tidar',
            'Universitas Teuku Umar',
            'Universitas Malikussaleh',
            'Universitas Negeri Manado',
            'Universitas Musamus Merauke',
            'Universitas Khairun',
            'Universitas Palangka Raya',
            'Universitas Pattimura',
            'Universitas Nusa Cendana',
            'Universitas Bangka Belitung',
            'Universitas Borneo Tarakan',
            'Universitas Negeri Gorontalo',
            'Universitas Jenderal Soedirman',
            'Universitas Negeri Medan',
        ];

        foreach ($universitas as $nama) {
            DB::table('institusi_pendidikan')->insert([
                'nama_institusi' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}