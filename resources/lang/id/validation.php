<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut ini berisi standar pesan kesalahan yang digunakan oleh
    | kelas validasi. Beberapa aturan mempunyai multi versi seperti aturan 'size'.
    | Jangan ragu untuk mengoptimalkan setiap pesan yang ada di sini.
    |
    */

    'accepted' => 'Isian kolom :attribute harus diterima.',
    'active_url' => 'Isian kolom :attribute bukan URL yang valid.',
    'after' => 'Isian kolom :attribute harus tanggal setelah :date.',
    'after_or_equal' => 'Isian kolom :attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => 'Isian kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Isian kolom :attribute hanya boleh berisi huruf, angka, strip, dan underscore.',
    'alpha_num' => 'Isian kolom :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Isian kolom :attribute harus berupa sebuah array.',
    'before' => 'Isian kolom :attribute harus tanggal sebelum :date.',
    'before_or_equal' => 'Isian kolom :attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Isian kolom :attribute harus antara :min sampai :max.',
        'file' => 'Berkas :attribute harus berukuran antara :min sampai :max kilobytes.',
        'string' => 'Isian kolom :attribute harus antara :min sampai :max karakter.',
        'array' => 'Isian kolom :attribute harus antara :min sampai :max item.',
    ],
    'boolean' => 'Isian kolom :attribute hanya boleh berisi true atau false.',
    'confirmed' => 'Isian kolom konfirmasi :attribute tidak cocok.',
    'date' => 'Isian kolom :attribute bukan tanggal yang valid.',
    'date_equals' => 'Isian kolom :attribute harus berisi sebuah tanggal yang sama dengan :date.',
    'date_format' => 'Isian kolom :attribute harus sesuai format (:format).',
    'different' => 'Isian kolom :attribute dan :other harus berbeda.',
    'digits' => 'Isian kolom :attribute harus berisi angka dengan panjang :digits digit.',
    'digits_between' => 'Isian kolom :attribute harus berisi angka dengan panjang antara :min sampai :max digit.',
    'dimensions' => 'Isian kolom :attribute terdapat dimensi gambar yang tidak valid.',
    'distinct' => 'Isian kolom :attribute tidak boleh terdapat duplikasi nilai.',
    'email' => 'Isian kolom :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Isian kolom :attribute harus berakhiran salah satu dari: :values',
    'exists' => 'Isian kolom :attribute yang dipilih tidak valid.',
    'file' => 'Isian kolom :attribute harus berupa file.',
    'filled' => 'Kolom :attribute wajib diisi.',
    'gt' => [
        'numeric' => 'Isian kolom :attribute harus lebih dari :value.',
        'file' => 'Isian kolom :attribute harus lebih dari :value kilobytes.',
        'string' => 'Isian kolom :attribute harus lebih dari :value characters.',
        'array' => 'Isian kolom :attribute harus mempunyai item lebih dari :value.',
    ],
    'gte' => [
        'numeric' => 'Isian kolom :attribute harus lebih dari atau sama dengan :value.',
        'file' => 'Isian kolom :attribute harus lebih dari atau sama dengan :value kilobytes.',
        'string' => 'Isian kolom :attribute harus lebih dari atau sama dengan :value characters.',
        'array' => 'Isian kolom :attribute harus mempunyai :value item atau lebih.',
    ],
    'image' => 'Isian kolom :attribute harus berupa gambar.',
    'in' => 'Isian kolom :attribute yang dipilih tidak valid.',
    'in_array' => 'Isian kolom :attribute tidak terdapat pada :other.',
    'integer' => 'Isian kolom :attribute harus merupakan bilangan bulat.',
    'ip' => 'Isian kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Isian kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Isian kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Isian kolom :attribute harus berupa JSON yang valid.',
    'lt' => [
        'numeric' => 'Isian kolom :attribute harus kurang dari :value.',
        'file' => 'Isian kolom :attribute harus kurang dari :value kilobytes.',
        'string' => 'Isian kolom :attribute harus kurang dari :value characters.',
        'array' => 'Isian kolom :attribute harus mempunyai item kurang dari :value.',
    ],
    'lte' => [
        'numeric' => 'Isian kolom :attribute harus kurang dari atau sama dengan :value.',
        'file' => 'Isian kolom :attribute harus kurang dari atau sama dengan :value kilobytes.',
        'string' => 'Isian kolom :attribute harus kurang dari atau sama dengan :value characters.',
        'array' => 'Isian kolom :attribute tidak boleh lebih dari :value item.',
    ],
    'max' => [
        'numeric' => 'Isian kolom :attribute tidak boleh lebih dari :max.',
        'file' => 'Isian kolom :attribute tidak boleh lebih dari :max kilobytes.',
        'string' => 'Isian kolom :attribute tidak boleh lebih dari :max karakter.',
        'array' => 'Isian kolom :attribute tidak boleh lebih dari :max item.',
    ],
    'mimes' => 'Isian kolom :attribute hanya boleh berupa file berjenis : :values.',
    'mimetypes' => 'Isian kolom :attribute hanya boleh berupa file berjenis : :values.',
    'min' => [
        'numeric' => 'Isian kolom :attribute minimal harus :min.',
        'file' => 'Isian kolom :attribute minimal harus :min kilobytes.',
        'string' => 'Isian kolom :attribute minimal harus :min karakter.',
        'array' => 'Isian kolom :attribute minimal harus :min item.',
    ],
    'not_in' => 'Isian kolom :attribute yang dipilih tidak valid.',
    'not_regex' => 'Isian kolom :attribute tidak sesuai format.',
    'numeric' => 'Isian kolom :attribute harus berupa angka.',
    'password' => 'Isian kolom password salah.',
    'present' => 'Kolom :attribute harus ada.',
    'regex' => 'Format isian kolom :attribute tidak valid.',
    'required' => 'Kolom :attribute harus diisi.',
    'required_if' => 'Kolom :attribute harus diisi bila :other adalah :value.',
    'required_unless' => 'Kolom :attribute harus diisi bila :other bernilai :values.',
    'required_with' => 'Kolom :attribute harus diisi bila terdapat :values.',
    'required_with_all' => 'Kolom :attribute harus diisi bila terdapat :values.',
    'required_without' => 'Kolom :attribute harus diisi bila tidak terdapat :values.',
    'required_without_all' => 'Kolom :attribute harus diisi bila :values tidak ada.',
    'same' => 'Isian kolom :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Isian kolom :attribute harus berisi :size.',
        'file' => 'Berkas :attribute harus berukuran :size kilobyte.',
        'string' => 'Isian kolom :attribute harus berisi :size karakter.',
        'array' => 'Isian kolom :attribute harus mengandung :size item.',
    ],
    'starts_with' => 'Isian kolom :attribute harus diawali dengan salah satu dari: :values',
    'string' => 'Isian kolom :attribute harus berupa string.',
    'timezone' => 'Isian kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Isian kolom :attribute sudah ada sebelumnya.',
    'uploaded' => 'Isian kolom :attribute gagal di unggah.',
    'url' => 'Isian kolom :attribute tidak sesuai format.',
    'uuid' => 'Isian kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut dengan menggunakan
    | konvensi "attribute.rule" dalam penamaan baris. Hal ini membuat cepat dalam
    | menentukan spesifik baris bahasa kustom untuk aturan atribut yang diberikan.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Kustom Validasi Atribut
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar atribut 'place-holders'
    | dengan sesuatu yang lebih bersahabat dengan pembaca seperti Alamat Email daripada
    | "email" saja. Ini benar-benar membantu kita membuat pesan sedikit bersih.
    |
    */

    'attributes' => [
        'name' => 'Nama',
        'address' => 'Alamat',
        'role' => 'Jabatan',
        'gender' => 'Jenis Kelamin',
        'phone' => 'No Telefon',
        'birth_place' => 'Tempat Lahir',
        'birth_date' => 'Tanggal Lahir',
        'nickname' => 'Nama Panggilan',
        'no_kk' => 'No Kartu Keluarga',
        'previous_school' => 'Asal Sekolah',
        'previous_school_address' => 'Alamat Asal Sekolah',
        'father_name' => 'Nama Bapak',
        'father_phone' => 'No Telefon Bapak',
        'mother_name' => 'Nama Ibu',
        'mother_phone' => 'No Telefon Ibu',
        'wali_name' => 'Nama Wali',
        'wali_phone' => 'No Telefon Wali',
        'selection_method' => 'Jalur Pendaftaran',
        'approval' => 'Persetujuan',
    ],
];
