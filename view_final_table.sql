SELECT
    view_grand_table.id_output_user,
    view_grand_table.id_tgj,
    view_grand_table.kode_sasaranstrategis,
    view_grand_table.nama_sasaranstrategis,
    view_grand_table.kode_indikatorutama,
    view_grand_table.nama_indikatorutama,
    view_grand_table.volume_indikatorutama,
    view_grand_table.satuan_indikatorutama,
    view_grand_table.kode_program,
    view_grand_table.nama_program,
    view_grand_table.kode_sasaranprogram,
    view_grand_table.nama_sasaranprogram,
    view_grand_table.kode_indikatorprogram,
    view_grand_table.nama_indikatorprogram,
    view_grand_table.volume_indikatorprogram,
    view_grand_table.satuan_indikatorprogram,
    view_grand_table.kode_kegiatan,
    view_grand_table.nama_kegiatan,
    view_grand_table.kode_sasarankegiatan,
    view_grand_table.nama_sasarankegiatan,
    view_grand_table.kode_indikatorkegiatan,
    view_grand_table.nama_indikatorkegiatan,
    view_grand_table.volume_indikatorkegiatan,
    view_grand_table.satuan_indikatorkegiatan,
    view_grand_table.kode_output,
    view_grand_table.nama_output,
    view_grand_table.volume_output,
    view_grand_table.satuan_output,
    komponen.kode_komponen,
    komponen.nama_komponen,
    aktivitas.kode_aktivitas,
    aktivitas.nama_aktivitas,
    akun.id_akun,
    akun.kode_akun,
    akun.nama_akun,
    detail.nama_detail,
    detail.volume_detail,
    detail.satuan_detail,
    detail.harga_detail,
    detail.alokasi_detail
FROM
    view_grand_table
    LEFT JOIN komponen
        ON komponen.id_output_user = view_grand_table.id_output_user
    LEFT JOIN aktivitas
        ON aktivitas.id_komponen = komponen.id_komponen
    LEFT JOIN header
        ON header.id_aktivitas = aktivitas.id_aktivitas
    LEFT JOIN akun
        ON akun.id_akun = header.id_akun
    LEFT JOIN detail
        ON detail.id_header = header.id_header
;