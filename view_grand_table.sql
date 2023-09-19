SELECT
	output_user.id_tgj,
	sasaran_strategis.kode_sasaranstrategis,
	sasaran_strategis.nama_sasaranstrategis,
	indikator_utama.kode_indikatorutama,
	indikator_utama.nama_indikatorutama,
	compile_output.volume_indikatorutama,
	compile_output.satuan_indikatorutama,
	program.kode_program,
	program.nama_program,
	sasaran_program.kode_sasaranprogram,
	sasaran_program.nama_sasaranprogram,
	indikator_program.kode_indikatorprogram,
	indikator_program.nama_indikatorprogram,
	compile_output.volume_indikatorprogram,
	compile_output.satuan_indikatorprogram,
	kegiatan.kode_kegiatan,
	kegiatan.nama_kegiatan,
	sasaran_kegiatan.kode_sasarankegiatan,
	sasaran_kegiatan.nama_sasarankegiatan,
	indikator_kegiatan.kode_indikatorkegiatan,
	indikator_kegiatan.nama_indikatorkegiatan,
	compile_output.volume_indikatorkegiatan,
	compile_output.satuan_indikatorkegiatan,
	output.kode_output,
	output.nama_output,
	output_user.volume_output,
	output_user.satuan_output
FROM
    output_user
    LEFT JOIN compile_output ON output_user.id_compile = compile_output.id_compile
    LEFT JOIN sasaran_strategis ON compile_output.id_sasaranstrategis = sasaran_strategis.id_sasaranstrategis
    LEFT JOIN indikator_utama ON compile_output.id_indikatorutama = indikator_utama.id_indikatorutama
    LEFT JOIN sasaran_program ON compile_output.id_sasaranprogram = sasaran_program.id_sasaranprogram
    LEFT JOIN indikator_program ON compile_output.id_indikatorprogram = indikator_program.id_indikatorprogram
    LEFT JOIN indikator_kegiatan ON compile_output.id_indikatorkegiatan = indikator_kegiatan.id_indikatorkegiatan
    LEFT JOIN sasaran_kegiatan ON compile_output.id_sasarankegiatan = sasaran_kegiatan.id_sasarankegiatan
    LEFT JOIN output ON compile_output.id_output = output.id_output
    LEFT JOIN program ON compile_output.id_program = program.id_program
    LEFT JOIN kegiatan ON compile_output.id_kegiatan = kegiatan.id_kegiatan
    LEFT JOIN tgj ON output_user.id_tgj = tgj.id_tgj
;