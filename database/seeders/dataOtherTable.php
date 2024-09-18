<?php

namespace Database\Seeders;

use App\Models\url\tb_other;
use Illuminate\Database\Seeder;

class dataOtherTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_link' => 1,
                'title' => 'URL VIDEO UTAMA',
                'description' => 'ini video utama',
                'is_used' => 0,
                'type' => 'url',
                'url' => 'https://youtu.be/koZXdinR8jg?si=gR2L591SXYEcapF0',
                'created_at' => null,
                'updated_at' => '2024-09-10T14:56:36.000000Z',
            ],
            [
                'id_link' => 2,
                'title' => 'URL VIDEO SECOND',
                'description' => 'ini video ke 2',
                'is_used' => 1,
                'type' => 'url',
                'url' => 'https://youtu.be/B6A1YQ0eRUo?si=mLHxDpLJweYOs3Za',
                'created_at' => null,
                'updated_at' => '2024-09-10T21:24:55.000000Z',
            ],
            [
                'id_link' => 3,
                'title' => 'URL VIDEO KEMITRAAN',
                'description' => null,
                'is_used' => 0,
                'type' => 'url',
                'url' => 'https://youtu.be/nfgxLMB4N2k?si=-gqcOODu7dzV7Y5M',
                'created_at' => null,
                'updated_at' => '2024-09-18T14:46:22.000000Z',
            ],
            [
                'id_link' => 4,
                'title' => 'Komite',
                'description' => 'AC_test-pdf_11-21-59.pdf',
                'is_used' => 0,
                'type' => 'file',
                'url' => 'http://127.0.0.1:8000/data-pdf/651612345bd5c8dd4f93e3786f1d2e5bfed6306113bc51984db3eaff83efad9f.pdf',
                'created_at' => null,
                'updated_at' => '2024-09-18T16:24:37.000000Z',
            ],
            [
                'id_link' => 5,
                'title' => 'Program Kerja',
                'description' => null,
                'is_used' => 0,
                'type' => 'url',
                'url' => 'http://127.0.0.1:8000/data-pdf/JADWAL_RPL 22_23.pdf',
                'created_at' => null,
                'updated_at' => '2024-09-18T16:26:45.000000Z',
            ],
            [
                'id_link' => 6,
                'title' => 'VIsi & MIsi',
                'description' => '<p>abal abal</p>',
                'is_used' => 0,
                'type' => 'text',
                'url' => '?????',
                'created_at' => null,
                'updated_at' => '2024-09-18T16:27:08.000000Z',
            ],
            [
                'id_link' => 7,
                'title' => 'Struktur',
                'description' => 'newton.pdf',
                'is_used' => 0,
                'type' => 'file',
                'url' => 'http://127.0.0.1:8000/data-pdf/1005b8c73d4e2da03fba1911b2ab531962d7cd6d1b9011c640d566d465a1cd27.pdf',
                'created_at' => null,
                'updated_at' => '2024-09-18T16:27:36.000000Z',
            ],
        ];

        foreach ($data as $d) {
            tb_other::create($d);
        }
    }
}
