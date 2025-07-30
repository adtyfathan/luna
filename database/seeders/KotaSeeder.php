<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kotas = [
            'Kabupaten Aceh Barat', 'Kabupaten Aceh Barat Daya', 'Kabupaten Aceh Besar',
            'Kabupaten Aceh Jaya', 'Kabupaten Aceh Selatan', 'Kabupaten Aceh Singkil',
            'Kabupaten Aceh Tamiang', 'Kabupaten Aceh Tengah', 'Kabupaten Aceh Tenggara',
            'Kabupaten Aceh Timur', 'Kabupaten Aceh Utara', 'Kabupaten Bener Meriah',
            'Kabupaten Bireuen', 'Kabupaten Gayo Lues', 'Kabupaten Nagan Raya',
            'Kabupaten Pidie', 'Kabupaten Pidie Jaya', 'Kabupaten Simeulue',
            'Kota Banda Aceh', 'Kota Langsa', 'Kota Lhokseumawe', 'Kota Sabang',
            'Kota Subulussalam', 'Kabupaten Asahan', 'Kabupaten Batu Bara', 'Kabupaten Dairi',
            'Kabupaten Deli Serdang', 'Kabupaten Humbang Hasundutan', 'Kabupaten Karo',
            'Kabupaten Labuhanbatu', 'Kabupaten Labuhanbatu Selatan', 'Kabupaten Labuhanbatu Utara',
            'Kabupaten Langkat', 'Kabupaten Mandailing Natal', 'Kabupaten Nias',
            'Kabupaten Nias Barat', 'Kabupaten Nias Selatan', 'Kabupaten Nias Utara',
            'Kabupaten Padang Lawas', 'Kabupaten Padang Lawas Utara', 'Kabupaten Pakpak Bharat',
            'Kabupaten Samosir', 'Kabupaten Serdang Bedagai', 'Kabupaten Simalungun',
            'Kabupaten Tapanuli Selatan', 'Kabupaten Tapanuli Tengah', 'Kabupaten Tapanuli Utara',
            'Kabupaten Toba', 'Kota Binjai', 'Kota Gunungsitoli', 'Kota Medan',
            'Kota Padang Sidempuan', 'Kota Pematang Siantar', 'Kota Sibolga', 'Kota Tanjungbalai',
            'Kota Tebing Tinggi', 'Kabupaten Agam', 'Kabupaten Dharmasraya',
            'Kabupaten Kepulauan Mentawai', 'Kabupaten Lima Puluh Kota', 'Kabupaten Padang Pariaman',
            'Kabupaten Pasaman', 'Kabupaten Pasaman Barat', 'Kabupaten Pesisir Selatan',
            'Kabupaten Sijunjung', 'Kabupaten Solok', 'Kabupaten Solok Selatan',
            'Kabupaten Tanah Datar', 'Kota Bukittinggi', 'Kota Padang', 'Kota Padang Panjang',
            'Kota Pariaman', 'Kota Payakumbuh', 'Kota Sawahlunto', 'Kota Solok',
            'Kabupaten Bengkalis', 'Kabupaten Indragiri Hilir', 'Kabupaten Indragiri Hulu',
            'Kabupaten Kampar', 'Kabupaten Kepulauan Meranti', 'Kabupaten Kuantan Singingi',
            'Kabupaten Pelalawan', 'Kabupaten Rokan Hilir', 'Kabupaten Rokan Hulu',
            'Kabupaten Siak', 'Kota Dumai', 'Kota Pekanbaru',
            'Kabupaten Batang Hari', 'Kabupaten Bungo', 'Kabupaten Kerinci', 'Kabupaten Merangin',
            'Kabupaten Muaro Jambi', 'Kabupaten Sarolangun', 'Kabupaten Tanjung Jabung Barat',
            'Kabupaten Tanjung Jabung Timur', 'Kabupaten Tebo', 'Kota Jambi', 'Kota Sungai Penuh',
            'Kabupaten Banyuasin', 'Kabupaten Empat Lawang', 'Kabupaten Lahat',
            'Kabupaten Muara Enim', 'Kabupaten Musi Banyuasin', 'Kabupaten Musi Rawas',
            'Kabupaten Musi Rawas Utara', 'Kabupaten Ogan Ilir', 'Kabupaten Ogan Komering Ilir',
            'Kabupaten Ogan Komering Ulu', 'Kabupaten Ogan Komering Ulu Selatan',
            'Kabupaten Ogan Komering Ulu Timur', 'Kota Lubuklinggau', 'Kota Pagar Alam',
            'Kota Palembang', 'Kota Prabumulih', 'Kabupaten Bengkulu Selatan',
            'Kabupaten Bengkulu Tengah', 'Kabupaten Bengkulu Utara', 'Kabupaten Kaur',
            'Kabupaten Kepahiang', 'Kabupaten Lebong', 'Kabupaten Muko Muko',
            'Kabupaten Rejang Lebong', 'Kabupaten Seluma', 'Kota Bengkulu',
        ];

        foreach ($kotas as $kota) {
            DB::table('kota')->insert([
                'nama_kota' => $kota,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}