<?php

namespace App\Support;

class Pesan
{
    public static function umum(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa teks.',
            'integer'  => ':attribute harus berupa angka bulat.',
            'numeric'  => ':attribute harus berupa angka.',
            'date'     => ':attribute harus berupa tanggal yang valid.',
            'email'    => 'Format :attribute tidak valid.',
            'unique'   => ':attribute sudah dipakai.',
            'exists'   => ':attribute yang dipilih tidak valid.',
            'in'       => ':attribute yang dipilih tidak valid.',
            'array'    => ':attribute tidak valid.',
            'after_or_equal' => ':attribute tidak boleh lebih awal dari tanggal awal.',
            'min' => [
                'numeric' => ':attribute minimal :min.',
                'string'  => ':attribute minimal :min karakter.',
                'array'   => ':attribute minimal :min pilihan.',
            ],
            'max' => [
                'numeric' => ':attribute maksimal :max.',
                'string'  => ':attribute maksimal :max karakter.',
                'array'   => ':attribute maksimal :max pilihan.',
            ],
        ];
    }
}
