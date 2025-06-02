<?php

namespace App\Imports;

use App\Models\tb_ptk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PTKImport implements ToCollection
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
                    'nama' => $row[1],
                    'nip' => $row[2],
                    'nuptk' => $row[3],
                    'tempat_lahir' => $row[4],
                    'tanggal_lahir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]),
                    'jenis_kelamin' => $row[6],
                    'mata_pelajaran' => $row[7],
                    'alamat' => $row[8],
                ];
                tb_ptk::create($data);
            }
            $index++;
        }
    }
}
