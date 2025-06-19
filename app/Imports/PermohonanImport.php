<?php

namespace App\Imports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PermohonanImport implements ToModel, WithHeadingRow
{
    /**
     * Membersihkan value dari spasi/tab/enter berlebihan
     *
     * @param string|null $value
     * @return string|null
     */


    /**
     * Mapping baris Excel ke model Permohonan
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
         if (
        empty($row['nomordokumen']) &&
        empty($row['nama_wp']) &&
        empty($row['alamat_wp']) &&
        empty($row['nop']) &&
        empty($row['alamat_objek']) &&
        empty($row['tujuan']) &&
        empty($row['dokumen'])
    ) {
        return null;
    }

       return new Permohonan([
            'nomordokumen' => trim($row['nomordokumen'] ?? ''),
            'nama_wp'     => trim($row['nama_wp'] ?? ''),
            'alamat_wp'   => trim($row['alamat_wp'] ?? ''),
            'nop'         => trim($row['nop'] ?? ''),
            'alamat_objek'=> trim($row['alamat_objek'] ?? ''),
            'tujuan'      => trim($row['tujuan'] ?? ''),
            'dokumen'     => trim($row['dokumen'] ?? ''), // Link dokumen dari Excel
            'status'      => trim($row['status'] ?? '') ?: 'Menunggu',
        ]);
    }
}
