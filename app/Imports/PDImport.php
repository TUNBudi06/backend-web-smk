<?php

namespace App\Imports;

use App\Models\tb_peserta_didik;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PDImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $index = 1;

        foreach ($collection as $row) {
            if ($index > 1 && $row->filter()->isNotEmpty()) {
                $data = [
                    'nisn' => $row[1],
                    'nis' => $row[2],
                    'nama' => $row[3],
                    'kelas' => $row[4],
                    'tempat_lahir' => $row[5],
                    'tanggal_lahir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]),
                    'agama' => $row[7],
                    'gender' => $row[8],
                    'telp' => $row[9],
                    'alamat' => $row[10],
                ];
                tb_peserta_didik::create($data);
            }
            $index++;
        }
    }
}
