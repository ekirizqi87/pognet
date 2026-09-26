localhost/INFORMATION_SCHEMA/COLUMNS/		https://103.172.118.9:8090/phpmyadmin/index.php?route=/database/sql&db=demo_demognetindo

   Showing rows 0 - 499 (1646 total, Query took 0.0154 seconds.)


SELECT
    TABLE_NAME AS `Tabel`,
    ORDINAL_POSITION AS `Urutan`,
    COLUMN_NAME AS `Kolom`,
    COLUMN_TYPE AS `Tipe Data`,
    IS_NULLABLE AS `Nullable`,
    COLUMN_DEFAULT AS `Default`,
    COLUMN_KEY AS `Key`,
    EXTRA AS `Extra`
FROM
    INFORMATION_SCHEMA.COLUMNS
WHERE
    TABLE_SCHEMA = 'demo_demognetindo'
ORDER BY
    TABLE_NAME,
    ORDINAL_POSITION;


Tabel	Urutan	Kolom	Tipe Data	Nullable	Default	Key	Extra	
ap	1	id_ap	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
ap	2	created_at	datetime	YES	NULL			
ap	3	created_by	int(11)	YES	NULL			
ap	4	updated_at	datetime	YES	NULL			
ap	5	updated_by	int(11)	YES	NULL			
ap	6	transaksi_id	bigint(20)	YES	NULL	MUL		
ap	7	transaksi_kode	varchar(30)	YES	NULL			
ap	8	jenis_transaksi	varchar(255)	YES	NULL			
ap	9	tgl_ap	date	YES	NULL			
ap	10	cabang_id	int(11)	YES	1			
ap	11	vendor_id	int(11)	YES	NULL			
ap	12	keterangan	varchar(10)	YES	NULL			
ap	13	jumlah_transaksi	decimal(10,0)	YES	0			
ap	14	jumlah_alokasi	decimal(10,0)	YES	0			
ap	15	jumlah_approve	decimal(10,0)	YES	0			
ap	16	saldo	decimal(10,0)	YES	0			
ar	1	id_ar	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
ar	2	created_at	datetime	YES	NULL			
ar	3	created_by	int(11)	YES	NULL			
ar	4	updated_at	datetime	YES	NULL			
ar	5	updated_by	int(11)	YES	NULL			
ar	6	transaksi_id	bigint(20)	NO	NULL	MUL		
ar	7	transaksi_kode	varchar(30)	YES	NULL			
ar	8	jenis_transaksi	varchar(255)	YES	NULL			
ar	9	tgl_ar	date	YES	NULL			
ar	10	cabang_id	int(11)	YES	1	MUL		
ar	11	vendor_id	int(11)	YES	NULL	MUL		
ar	12	keterangan	varchar(10)	YES	NULL			
ar	13	jumlah_transaksi	decimal(10,0)	YES	0			
ar	14	jumlah_alokasi	decimal(10,0)	YES	0			
ar	15	jumlah_approve	decimal(10,0)	YES	0			
ar	16	saldo	decimal(10,0)	YES	0			
aset	1	id_aset	int(10) unsigned	NO	NULL	PRI	auto_increment	
aset	2	created_at	datetime	NO	NULL			
aset	3	created_by	int(11)	NO	NULL			
aset	4	updated_at	datetime	YES	NULL			
aset	5	updated_by	int(11)	YES	NULL			
aset	6	kategori_aset_id	int(11)	YES	NULL			
aset	7	kd_aset	varchar(50)	NO	NULL	UNI		
aset	8	nm_aset	varchar(255)	NO	NULL			
aset	9	kondisi	varchar(100)	YES	NULL			
aset	10	harga_perolehan	decimal(16,0)	YES	NULL			
aset	11	keterangan	text	YES	NULL			
aset	12	lokasi_id	int(11)	YES	NULL			
aset	13	tgl_perolehan	date	YES	NULL			
aset	14	cabang_id	int(11)	YES	NULL			
aset	15	cabang_alokasi_id	int(11)	YES	NULL			
aset	16	nm_merek	varchar(255)	YES	NULL			
aset	17	sn	varchar(255)	YES	NULL			
aset	18	keterangan_aset	varchar(255)	YES	NULL			
aset	19	qty	int(11)	YES	NULL			
aset	20	karyawan_penerima_id	int(11)	YES	NULL			
aset	21	gambar_qrcode	text	YES	NULL			
aset	22	nilai_perolehan	int(11)	YES	0			
aset	23	is_hapus	int(11)	YES	0			
aset	24	is_jual	int(11)	YES	NULL			
aset	25	tgl_penggunaan	date	YES	NULL			
bayar_hutang_karyawan	1	id_bayar_hutang	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
bayar_hutang_karyawan	2	created_at	datetime	NO	NULL			
bayar_hutang_karyawan	3	created_by	int(11)	NO	NULL			
bayar_hutang_karyawan	4	updated_at	datetime	YES	NULL			
bayar_hutang_karyawan	5	updated_by	int(11)	YES	NULL			
bayar_hutang_karyawan	6	kd_bayar	varchar(50)	NO	NULL			
bayar_hutang_karyawan	7	tgl_bayar	date	NO	NULL			
bayar_hutang_karyawan	8	hutang_id	int(11)	NO	NULL			
bayar_hutang_karyawan	9	coa_id	varchar(255)	NO	NULL			
bayar_hutang_karyawan	10	nilai	int(11)	NO	NULL			
bayar_hutang_karyawan	11	keterangan	text	YES	NULL			
bayar_hutang_karyawan	12	cabang_id	int(11)	YES	NULL			
bayar_hutang_karyawan	13	status	tinyint(4)	YES	NULL			
bayar_hutang_karyawan	14	tgl_batal	date	YES	NULL			
bayar_hutang_karyawan	15	keterangan_batal	varchar(255)	YES	NULL			
bayar_hutang_karyawan	16	status_approval	tinyint(4)	YES	0			
bayar_hutang_karyawan	17	tgl_approval	date	YES	NULL			
bayar_hutang_karyawan	18	keterangan_approval	text	YES	NULL			
bayar_hutang_karyawan	19	karyawan_approval_id	bigint(20)	YES	NULL			
biaya_internet	1	id_biaya	int(10) unsigned	NO	NULL	PRI	auto_increment	
biaya_internet	2	created_at	datetime	NO	NULL			
biaya_internet	3	created_by	int(11)	NO	NULL			
biaya_internet	4	updated_at	datetime	YES	NULL			
biaya_internet	5	updated_by	int(11)	YES	NULL			
biaya_internet	6	kd_biaya	varchar(50)	YES	NULL	UNI		
biaya_internet	7	vendor_id	int(11)	YES	NULL	MUL		
biaya_internet	8	keterangan	text	YES	NULL			
biaya_internet	9	cabang_id	int(11)	YES	NULL			
biaya_internet	10	nilai	int(11)	YES	NULL			
bulk_reminders	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
bulk_reminders	2	user_id	bigint(20) unsigned	NO	NULL	MUL		
bulk_reminders	3	campaign_name	varchar(255)	NO	NULL			
bulk_reminders	4	status	enum('pending','processing','completed','failed')	NO	'pending'			
bulk_reminders	5	total_recipients	int(11)	NO	0			
bulk_reminders	6	sent_count	int(11)	NO	0			
bulk_reminders	7	failed_count	int(11)	NO	0			
bulk_reminders	8	message_template	text	NO	NULL			
bulk_reminders	9	filter_criteria	longtext	YES	NULL			
bulk_reminders	10	scheduled_at	timestamp	YES	NULL			
bulk_reminders	11	completed_at	timestamp	YES	NULL			
bulk_reminders	12	created_at	timestamp	YES	NULL			
bulk_reminders	13	updated_at	timestamp	YES	NULL			
cabang	1	id_cabang	int(10) unsigned	NO	NULL	PRI	auto_increment	
cabang	2	created_at	datetime	NO	NULL			
cabang	3	created_by	int(11)	NO	NULL			
cabang	4	updated_at	datetime	YES	NULL			
cabang	5	updated_by	int(11)	YES	NULL			
cabang	6	nm_cabang	varchar(255)	NO	NULL			
cabang	7	alamat_cabang	varchar(255)	NO	NULL			
cabang	8	kd_cabang	varchar(20)	YES	NULL			
cabang	9	no_telp_cabang	varchar(15)	YES	NULL			
cabang	10	status_cabang	tinyint(1)	YES	1			
cabang	11	nm_perusahaan	varchar(100)	YES	NULL			
cabang	12	kota_print	varchar(100)	YES	NULL			
cabang	13	karyawan_kepala_cabang_id	int(10) unsigned	YES	NULL	MUL		
cabang	14	no_fax	varchar(30)	YES	NULL			
cabang	15	npwp_cabang	varchar(50)	YES	NULL			
cabang	16	area_id	int(11)	YES	NULL			
cabang	17	faktor_kali_servis	float	YES	0			
cabang	18	backdate	int(11)	NO	NULL			
cache	1	key	varchar(255)	NO	NULL	PRI		
cache	2	value	mediumtext	NO	NULL			
cache	3	expiration	int(11)	NO	NULL			
cache_locks	1	key	varchar(255)	NO	NULL	PRI		
cache_locks	2	owner	varchar(255)	NO	NULL			
cache_locks	3	expiration	int(11)	NO	NULL			
cek_toko	1	kd_toko	varchar(20)	NO	NULL	PRI		
closing	1	id_closing	int(11) unsigned	NO	NULL	PRI	auto_increment	
closing	2	created_at	datetime	NO	NULL			
closing	3	created_by	int(11)	NO	NULL			
closing	4	updated_at	datetime	YES	NULL			
closing	5	updated_by	int(11)	YES	NULL			
closing	6	tgl_closing	date	YES	NULL			
coa	1	id_coa	int(11) unsigned	NO	NULL	PRI	auto_increment	
coa	2	created_at	datetime	NO	NULL			
coa	3	created_by	int(11)	NO	NULL			
coa	4	updated_at	datetime	YES	NULL			
coa	5	updated_by	int(11)	YES	NULL			
coa	6	coa	varchar(20)	YES	NULL			
coa	7	parent_id	int(4)	YES	NULL	MUL		
coa	8	nm_coa	varchar(255)	NO	NULL			
coa	9	status	tinyint(4)	YES	1			
coa	10	transaction_type	varchar(1)	YES	NULL			
coa	11	kategori_coa	varchar(20)	YES	NULL			
coa	12	used_for	varchar(50)	YES	NULL			
coa	13	fk_jenis_cabang	varchar(30)	YES	NULL			
coa	14	cabang_aktif_id	varchar(30)	YES	NULL			
coa	15	is_gabungan_ho	tinyint(4)	YES	0			
coa	16	divisi_coa	char(1)	YES	NULL			
coa	17	hidden_kas_bank	tinyint(1)	YES	0			
customer	1	id_customer	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
customer	2	created_at	datetime	YES	NULL			
customer	3	created_by	int(11)	YES	NULL			
customer	4	updated_at	datetime	YES	NULL			
customer	5	updated_by	int(11)	YES	NULL			
customer	6	kd_customer	varchar(30)	YES	NULL	UNI		
customer	7	nm_customer	varchar(255)	NO	NULL			
customer	8	cabang_id	int(11) unsigned	YES	NULL	MUL		
customer	9	npwp	varchar(50)	YES	NULL			
customer	10	kecamatan_id	int(11)	YES	NULL	MUL		
customer	11	cek_tahap2_astinet	varchar(255)	YES	NULL			
customer	12	telp	varchar(255)	YES	NULL			
customer	13	email	varchar(100)	YES	NULL			
customer	14	password	varchar(255)	YES	NULL			
customer	15	ip_mikrotik2	varchar(50)	YES	NULL			
customer	16	nm_cp	varchar(100)	YES	NULL			
customer	17	telp_cp	varchar(10)	YES	NULL			
customer	18	am_vendor	varchar(20)	YES	NULL			
customer	19	status_customer	tinyint(1)	YES	1			
customer	20	alamat	text	YES	NULL			
customer	21	jenis_customer	varchar(20)	YES	NULL			
customer	22	tanda_pengenal	varchar(10)	YES	NULL			
customer	23	no_ktp	varchar(20)	YES	NULL			
customer	24	tempat_lahir	varchar(255)	YES	NULL			
customer	25	tgl_lahir	date	YES	NULL			
customer	26	is_toko_go	varchar(10)	YES	NULL			
customer	27	no_hp_personil_alfa	varchar(50)	YES	NULL			
customer	28	ip_mikrotik	varchar(30)	YES	NULL			
customer	29	is_customer_bengkel	tinyint(2)	YES	0	MUL		
customer	30	is_rosy	int(11) unsigned	YES	0	MUL		
customer	31	is_alfamart	tinyint(4)	YES	0			
customer	32	dc_id	int(11)	YES	NULL			
customer	33	tikor	text	YES	NULL			
customer	34	is_cover_astinet	tinyint(4)	YES	0			
customer	35	bw	varchar(255)	YES	NULL			
customer	36	harga_beli	int(11)	YES	NULL			
customer	37	harga_jual	int(11)	NO	0			
customer	38	tgl_aktivasi	date	YES	NULL			
customer	39	vendor_id	int(11)	YES	NULL			
customer	40	no_hp	varchar(20)	YES	NULL			
customer	41	is_cek_astinet	tinyint(4)	YES	NULL			
customer	42	is_migrasi_fo	tinyint(4)	YES	NULL			
customer	43	is_full_bulanan	tinyint(2)	NO	0			
customer	44	is_aktif	tinyint(2)	NO	1			
customer	45	no_hp2	varchar(30)	YES	NULL			
customer	46	nm_group_wa	text	YES	NULL			
customer	47	produk_id_use	int(11)	YES	NULL			
customer	48	is_tutup	int(11)	NO	0			
customer	49	keterangan_batal	text	YES	NULL			
customer	50	link_uat	text	YES	NULL			
customer	51	link_laporan	text	YES	NULL			
customer	52	no_baso	varchar(255)	YES	NULL			
customer	53	tgl_baso	date	YES	NULL			
customer	54	sid_telkom	varchar(255)	YES	NULL			
customer	55	tgl_aktivasi2	date	YES	NULL			
customer	56	keterangan	text	YES	NULL			
customer	57	ip	text	YES	NULL			
customer	58	status_koneksi	tinyint(4)	YES	0			
customer	59	down_time	datetime	YES	NULL			
customer	60	ip_ping	varchar(255)	YES	NULL			
customer	61	ip_gw	varchar(200)	YES	NULL			
customer	62	ip_forti	varchar(200)	YES	NULL			
customer	63	pppoe	varchar(255)	YES	NULL			
customer	64	password_pppoe	varchar(255)	YES	NULL			
customer	65	is_form_uat_3mbps	int(1)	NO	0			
customer	66	link_iform_uat_3mbps	text	YES	NULL			
customer	67	tipe_backup_link	varchar(100)	YES	NULL			
customer	68	ip_wan	varchar(100)	YES	NULL			
customer	69	ssid	varchar(100)	YES	NULL			
customer	70	password_ssid	varchar(255)	YES	NULL			
customer	71	mac_ap	varchar(255)	YES	NULL			
customer	72	mac_tablet	varchar(255)	YES	NULL			
customer	73	mac_pda	varchar(255)	YES	NULL			
customer	74	mac_akios	varchar(255)	YES	NULL			
customer	75	mac_tab_pda_2	varchar(255)	YES	NULL			
customer	76	status_ssid_hidden	varchar(255)	YES	NULL			
customer	77	mac_address_filtering	varchar(255)	YES	NULL			
customer	78	operator_main_link	varchar(255)	YES	NULL			
customer	79	operatos_backup_link	varchar(255)	YES	NULL			
customer	80	tgl_tutup	date	YES	NULL			
customer	81	tidak_cek_prtg	tinyint(1)	NO	0			
dc	1	id_dc	int(11)	NO	NULL	PRI	auto_increment	
dc	2	kd_dc	varchar(20)	NO	NULL			
dc	3	nm_dc	varchar(255)	NO	NULL			
districts	1	id	char(7)	NO	NULL	PRI		
districts	2	regency_id	char(4)	NO	NULL	MUL		
districts	3	name	varchar(255)	NO	NULL			
failed_jobs	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
failed_jobs	2	uuid	varchar(255)	NO	NULL	UNI		
failed_jobs	3	connection	text	NO	NULL			
failed_jobs	4	queue	text	NO	NULL			
failed_jobs	5	payload	longtext	NO	NULL			
failed_jobs	6	exception	longtext	NO	NULL			
failed_jobs	7	failed_at	timestamp	NO	current_timestamp()			
gaji	1	id_gaji	int(11) unsigned	NO	NULL	PRI	auto_increment	
gaji	2	created_at	datetime	NO	NULL			
gaji	3	created_by	int(11)	NO	NULL			
gaji	4	updated_at	datetime	YES	NULL			
gaji	5	updated_by	int(11)	YES	NULL			
gaji	6	kd_gaji	varchar(50)	YES	''			
gaji	7	tgl_gaji	date	YES	NULL			
gaji	8	coa_id	varchar(50)	NO	NULL			
gaji	9	karyawan_id	int(11)	NO	NULL			
gaji	10	bulan	varchar(100)	NO	NULL			
gaji	11	tahun	varchar(100)	YES	''			
gaji	12	jenis_gaji	varchar(255)	YES	''			
gaji	13	nilai	int(11)	YES	NULL			
gaji	14	keterangan	text	NO	NULL			
gaji	15	cabang_id	varchar(20)	YES	''			
gaji	16	tgl_batal	datetime	YES	NULL			
gaji	17	keterangan_batal	text	YES	NULL			
gateway_wa	1	id_gateway	int(10) unsigned	NO	NULL	PRI	auto_increment	
gateway_wa	2	created_at	datetime	NO	NULL			
gateway_wa	3	created_by	int(11)	NO	NULL			
gateway_wa	4	updated_at	datetime	YES	NULL			
gateway_wa	5	updated_by	int(11)	YES	NULL			
gateway_wa	6	no_hp	varchar(20)	YES	NULL			
gateway_wa	7	api_key	text	YES	NULL			
gateway_wa	8	number_key	text	YES	NULL			
gateway_wa	9	api_url	text	YES	NULL			
gateway_wa	10	keterangan	varchar(255)	YES	NULL			
gateway_wa	11	jenis	varchar(255)	YES	NULL			
gl_auto	1	no_bukti	int(11) unsigned	NO	NULL	PRI	auto_increment	
gl_auto	2	created_at	datetime	YES	NULL			
gl_auto	3	created_by	int(11)	YES	NULL			
gl_auto	4	updated_at	datetime	YES	NULL			
gl_auto	5	updated_by	int(11)	YES	NULL			
gl_auto	6	fk_owner	bigint(20) unsigned	YES	1			
gl_auto	7	tr_date	datetime	YES	NULL			
gl_auto	8	type_owner	varchar(255)	YES	NULL			
gl_auto	9	description	text	YES	NULL			
gl_auto	10	fk_coa_d	varchar(15)	YES	NULL			
gl_auto	11	fk_coa_c	varchar(15)	YES	NULL			
gl_auto	12	total	decimal(15,2)	YES	NULL			
gl_auto	13	customer_id	bigint(11) unsigned	YES	NULL	MUL		
gl_auto	14	vendor_id	bigint(11) unsigned	YES	NULL	MUL		
gl_auto	15	cabang_id	int(11)	YES	NULL	MUL		
gl_auto	16	jenis_cabang	varchar(255)	YES	NULL			
gl_auto	17	kode_gl	varchar(50)	YES	NULL			
gl_auto	18	no_referensi	varchar(50)	YES	NULL			
group_master	1	id_group_master	int(11) unsigned	NO	NULL	PRI	auto_increment	
group_master	2	nm_group	varchar(100)	YES	NULL			
gudang	1	id_gudang	int(11) unsigned	NO	NULL	PRI	auto_increment	
gudang	2	created_at	datetime	NO	NULL			
gudang	3	created_by	int(11)	NO	NULL			
gudang	4	updated_at	datetime	YES	NULL			
gudang	5	updated_by	int(11)	YES	NULL			
gudang	6	nm_gudang	varchar(255)	NO	NULL			
gudang	7	cabang_id	varchar(255)	NO	NULL	MUL		
gudang	8	jenis_gudang	varchar(15)	YES	NULL			
hutang_karyawan	1	id_hutang	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
hutang_karyawan	2	created_at	datetime	NO	NULL			
hutang_karyawan	3	created_by	int(11)	NO	NULL			
hutang_karyawan	4	updated_at	datetime	YES	NULL			
hutang_karyawan	5	updated_by	int(11)	YES	NULL			
hutang_karyawan	6	kd_hutang	varchar(50)	NO	NULL			
hutang_karyawan	7	tgl_hutang	date	NO	NULL			
hutang_karyawan	8	karyawan_id	int(11)	NO	NULL			
hutang_karyawan	9	nilai	int(11)	NO	NULL			
hutang_karyawan	10	keterangan	text	YES	NULL			
hutang_karyawan	11	cabang_id	int(11)	YES	NULL			
hutang_karyawan	12	status	tinyint(4)	YES	NULL			
hutang_karyawan	13	tgl_batal	date	YES	NULL			
hutang_karyawan	14	keterangan_batal	varchar(255)	YES	NULL			
hutang_karyawan	15	status_approval	tinyint(4)	YES	0			
hutang_karyawan	16	tgl_approval	date	YES	NULL			
hutang_karyawan	17	keterangan_approval	text	YES	NULL			
hutang_karyawan	18	karyawan_approval_id	bigint(20)	YES	NULL			
hutang_karyawan	19	potongan	int(11)	NO	NULL			
inventory_adjustment	1	id_ia	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
inventory_adjustment	2	created_at	datetime	NO	NULL			
inventory_adjustment	3	created_by	int(11)	NO	NULL			
inventory_adjustment	4	updated_at	datetime	YES	NULL			
inventory_adjustment	5	updated_by	int(11)	YES	NULL			
inventory_adjustment	6	kd_ia	varchar(30)	YES	NULL			
inventory_adjustment	7	tgl_ia	date	NO	NULL			
inventory_adjustment	8	cabang_id	int(11) unsigned	YES	NULL	MUL		
inventory_adjustment	9	group_product_id	int(11)	NO	NULL	MUL		
inventory_adjustment	10	jenis	varchar(20)	YES	NULL			
inventory_adjustment	11	coa_id	int(11) unsigned	YES	NULL	MUL		
inventory_adjustment	12	gudang_ia_id	int(11)	YES	NULL	MUL		
inventory_adjustment	13	total	decimal(10,0)	YES	0			
inventory_adjustment	14	status	tinyint(4)	YES	NULL			
inventory_adjustment	15	tgl_batal	date	YES	NULL			
inventory_adjustment	16	keterangan_batal	varchar(255)	YES	NULL			
inventory_adjustment	17	gudang_id	int(11)	YES	1	MUL		
inventory_adjustment	18	status_transfer	tinyint(4)	YES	1			
inventory_adjustment	19	status_approve	tinyint(1)	YES	0			
inventory_adjustment	20	keterangan_approve	text	YES	NULL			
inventory_adjustment	21	tgl_approve	date	YES	NULL			
inventory_adjustment	22	karyawan_approve_id	int(11)	YES	NULL	MUL		
inventory_adjustment_detail	1	id_ia_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
inventory_adjustment_detail	2	created_at	datetime	NO	NULL			
inventory_adjustment_detail	3	created_by	int(11)	NO	NULL			
inventory_adjustment_detail	4	updated_at	datetime	YES	NULL			
inventory_adjustment_detail	5	updated_by	int(11)	YES	NULL			
inventory_adjustment_detail	6	inventory_adjustment_id	bigint(20) unsigned	NO	NULL	MUL		
inventory_adjustment_detail	7	product_id	bigint(20) unsigned	YES	1	MUL		
inventory_adjustment_detail	8	harga_satuan	decimal(10,0)	YES	0			
inventory_adjustment_detail	9	qty	decimal(10,2)	YES	0.00			
inventory_adjustment_detail	10	total	decimal(10,0)	YES	NULL			
invoice	1	id_invoice	int(11) unsigned	NO	NULL	PRI	auto_increment	
invoice	2	created_at	datetime	YES	NULL			
invoice	3	created_by	int(11)	YES	NULL			
invoice	4	updated_at	datetime	YES	NULL			
invoice	5	updated_by	int(11)	YES	NULL			
invoice	6	kd_invoice	varchar(255)	YES	NULL			
invoice	7	tgl_invoice	date	NO	NULL			
invoice	8	so_id	varchar(50)	NO	NULL	MUL		
invoice	9	cabang_id	int(11) unsigned	YES	NULL	MUL		
invoice	10	status	varchar(20)	YES	NULL			
invoice	11	total_gross	int(11)	YES	0			
invoice	12	total_ppn	decimal(10,2)	YES	0.00			
invoice	13	total_diskon	int(11) unsigned	YES	0			
invoice	14	grand_total	int(11)	NO	0			
invoice	15	tgl_batal	date	YES	NULL			
invoice	16	keterangan_batal	varchar(255)	YES	NULL			
invoice	17	keterangan	text	YES	NULL			
invoice	18	termin_ke	int(11)	YES	0			
invoice	19	jumlah_persen	int(11)	YES	0			
invoice	20	is_ppn	tinyint(2)	YES	NULL			
invoice	21	bank	int(11)	YES	NULL			
invoice	22	link_fp	text	YES	NULL			
invoice	23	kompensasi	int(11)	YES	NULL			
invoice	24	due_date	date	YES	NULL			
invoice	25	jenis_invoice	varchar(100)	YES	NULL			
invoice_detail	1	id_invoice_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
invoice_detail	2	created_at	datetime	NO	NULL			
invoice_detail	3	created_by	int(11)	NO	NULL			
invoice_detail	4	updated_at	datetime	YES	NULL			
invoice_detail	5	updated_by	int(11)	YES	NULL			
invoice_detail	6	invoice_id	bigint(20) unsigned	NO	NULL	MUL		
invoice_detail	7	product_id	bigint(20) unsigned	YES	1	MUL		
invoice_detail	8	harga	decimal(10,0)	YES	0			
invoice_detail	9	qty	decimal(10,0)	YES	0			
invoice_detail	10	diskon	decimal(10,0)	YES	0			
invoice_detail	11	total	decimal(10,0)	YES	0			
invoice_detail	12	hpp	decimal(10,2)	YES	0.00			
invoice_detail	13	keterangan_detail	varchar(255)	YES	NULL			
invoice_detail	14	customer_id_detail	int(11)	YES	NULL			
invoice_detail	15	harga_dasar	int(11)	YES	NULL			
invoice_retail	1	id_invoice_retail	int(10) unsigned	NO	NULL	PRI	auto_increment	
invoice_retail	2	created_at	datetime	YES	NULL			
invoice_retail	3	created_by	int(11)	YES	NULL			
invoice_retail	4	updated_at	datetime	YES	NULL			
invoice_retail	5	updated_by	int(11)	YES	NULL			
invoice_retail	6	kd_invoice_retail	varchar(255)	YES	NULL	UNI		
invoice_retail	7	tgl_invoice_retail	date	NO	NULL			
invoice_retail	8	bulan_periode	varchar(50)	NO	NULL	MUL		
invoice_retail	9	tahun_periode	int(10) unsigned	YES	NULL			
invoice_retail	10	cabang_id	int(11)	YES	NULL			
invoice_retail	11	total_gross	int(11)	YES	0			
invoice_retail	12	total_ppn	decimal(10,2)	YES	0.00			
invoice_retail	13	total_diskon	int(10) unsigned	YES	0			
invoice_retail	14	grand_total	int(11)	NO	0			
invoice_retail	15	tgl_batal	date	YES	NULL			
invoice_retail	16	keterangan_batal	text	YES	NULL			
invoice_retail	17	keterangan	text	YES	NULL			
invoice_retail	18	produk_id	int(11)	YES	0			
invoice_retail	19	pelanggan_id	int(11)	YES	NULL			
invoice_retail	20	slug	text	YES	NULL	UNI		
invoice_retail	21	status_bayar	text	YES	NULL			
invoice_retail	22	slug2	text	YES	NULL			
invoice_retail	23	tgl_bayar	datetime	YES	NULL			
invoice_retail	24	metode_bayar	varchar(255)	YES	NULL			
invoice_servis_detail	1	id_invoice_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
invoice_servis_detail	2	created_at	datetime	NO	NULL			
invoice_servis_detail	3	created_by	int(11)	NO	NULL			
invoice_servis_detail	4	updated_at	datetime	YES	NULL			
invoice_servis_detail	5	updated_by	int(11)	YES	NULL			
invoice_servis_detail	6	invoice_id	bigint(20) unsigned	NO	NULL	MUL		
invoice_servis_detail	7	produk_id	bigint(11)	YES	NULL	MUL		
invoice_servis_detail	8	harga_satuan	decimal(10,0)	YES	NULL			
invoice_servis_detail	9	qty	decimal(10,0)	YES	NULL			
invoice_servis_detail	10	diskon_type	varchar(10)	YES	NULL			
invoice_servis_detail	11	diskon_value	decimal(10,0)	YES	NULL			
invoice_servis_detail	12	netto	decimal(10,0)	YES	NULL			
invoice_servis_detail	13	is_opb_invoice	tinyint(1)	YES	0	MUL		
invoice_servis_detail	14	nm_item_alias	varchar(255)	YES	NULL			
invoice_vendor	1	id_invoice	int(11) unsigned	NO	NULL	PRI	auto_increment	
invoice_vendor	2	created_at	datetime	NO	NULL			
invoice_vendor	3	created_by	int(11)	NO	NULL			
invoice_vendor	4	updated_at	datetime	YES	NULL			
invoice_vendor	5	updated_by	int(11)	YES	NULL			
invoice_vendor	6	kd_invoice	varchar(255)	NO	NULL			
invoice_vendor	7	tgl_invoice	varchar(255)	NO	NULL			
invoice_vendor	8	nilai	varchar(20)	YES	''			
invoice_vendor	9	vendor_id	varchar(15)	YES	''			
invoice_vendor	10	keterangan	text	YES	NULL			
invoice_vendor	11	tgl_batal	datetime	YES	NULL			
invoice_vendor	12	keterangan_batal	text	YES	NULL			
invoice_vendor	13	no_invoice_vendor	varchar(50)	YES	NULL			
invoice_vendor	14	tgl_invoice_vendor	date	YES	NULL			
invoice_vendor	15	is_perangkat	int(11)	YES	NULL			
jenis_olt	1	id_jenis_olt	int(10) unsigned	NO	NULL	PRI	auto_increment	
jenis_olt	2	created_at	datetime	NO	NULL			
jenis_olt	3	created_by	int(11)	NO	NULL			
jenis_olt	4	updated_at	datetime	YES	NULL			
jenis_olt	5	updated_by	int(11)	YES	NULL			
jenis_olt	6	kd_jenis_olt	varchar(50)	YES	NULL	UNI		
jenis_olt	7	nm_jenis_olt	varchar(255)	YES	NULL	MUL		
jenis_olt	8	jumlah_client	varchar(255)	YES	NULL			
jobs	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
jobs	2	queue	varchar(255)	NO	NULL	MUL		
jobs	3	payload	longtext	NO	NULL			
jobs	4	attempts	tinyint(3) unsigned	NO	NULL			
jobs	5	reserved_at	int(10) unsigned	YES	NULL			
jobs	6	available_at	int(10) unsigned	NO	NULL			
jobs	7	created_at	int(10) unsigned	NO	NULL			
job_batches	1	id	varchar(255)	NO	NULL	PRI		
job_batches	2	name	varchar(255)	NO	NULL			
job_batches	3	total_jobs	int(11)	NO	NULL			
job_batches	4	pending_jobs	int(11)	NO	NULL			
job_batches	5	failed_jobs	int(11)	NO	NULL			
job_batches	6	failed_job_ids	longtext	NO	NULL			
job_batches	7	options	mediumtext	YES	NULL			
job_batches	8	cancelled_at	int(11)	YES	NULL			
job_batches	9	created_at	int(11)	NO	NULL			
job_batches	10	finished_at	int(11)	YES	NULL			
jurnal_umum	1	id_jurnal	int(11) unsigned	NO	NULL	PRI	auto_increment	
jurnal_umum	2	created_at	datetime	NO	NULL			
jurnal_umum	3	created_by	int(11)	NO	NULL			
jurnal_umum	4	updated_at	datetime	YES	NULL			
jurnal_umum	5	updated_by	int(11)	YES	NULL			
jurnal_umum	6	kd_jurnal	varchar(50)	YES	NULL			
jurnal_umum	7	tgl_jurnal	date	NO	NULL			
jurnal_umum	8	cabang_id	int(11) unsigned	YES	NULL	MUL		
jurnal_umum	9	keterangan	text	NO	NULL			
jurnal_umum	10	karyawan_penerima_id	int(10) unsigned	YES	NULL	MUL		
jurnal_umum	11	total	decimal(10,0)	YES	NULL			
jurnal_umum	12	status_approval	tinyint(10)	YES	0			
jurnal_umum	13	tgl_approval	date	YES	NULL			
jurnal_umum	14	keterangan_approval	text	YES	NULL			
jurnal_umum	15	karyawan_approval_id	int(10) unsigned	YES	NULL	MUL		
jurnal_umum	16	tgl_batal	date	YES	NULL			
jurnal_umum	17	keterangan_batal	text	YES	NULL			
jurnal_umum_detail	1	id_jurnal_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
jurnal_umum_detail	2	created_at	datetime	NO	NULL			
jurnal_umum_detail	3	created_by	int(11)	NO	NULL			
jurnal_umum_detail	4	updated_at	datetime	YES	NULL			
jurnal_umum_detail	5	updated_by	int(11)	YES	NULL			
jurnal_umum_detail	6	jurnal_id	bigint(20) unsigned	NO	NULL	MUL		
jurnal_umum_detail	7	coa_id	bigint(20) unsigned	YES	1	MUL		
jurnal_umum_detail	8	type	char(1)	YES	'0'			
jurnal_umum_detail	9	nilai	decimal(10,0)	YES	0			
jurnal_umum_detail	10	keterangan_detail	text	YES	NULL			
kabupaten	1	id_kabupaten	int(11) unsigned	NO	NULL	PRI	auto_increment	
kabupaten	2	created_at	datetime	NO	NULL			
kabupaten	3	created_by	int(11)	NO	NULL			
kabupaten	4	updated_at	datetime	YES	NULL			
kabupaten	5	updated_by	int(11)	YES	NULL			
kabupaten	6	nm_kabupaten	varchar(255)	NO	NULL			
kabupaten	7	status_kabupaten	tinyint(1)	YES	1			
kabupaten	8	provinsi_id	int(11)	NO	NULL	MUL		
kartupasca	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
kartupasca	2	customer_id	bigint(20) unsigned	YES	NULL	UNI		
kartupasca	3	nomor_kartu	varchar(64)	NO	NULL	MUL		
kartupasca	4	jenis_kartu	varchar(64)	NO	NULL			
kartupasca	5	used_at	timestamp	YES	NULL			
kartupasca	6	toko_nama	varchar(120)	YES	NULL			
kartupasca	7	status	varchar(20)	NO	'tersedia'	MUL		
kartupasca	8	created_at	timestamp	YES	NULL			
kartupasca	9	updated_at	timestamp	YES	NULL			
kartupasca	10	product_id	int(11)	NO	108			
karyawan	1	id_karyawan	int(11) unsigned	NO	NULL	PRI	auto_increment	
karyawan	2	created_at	datetime	NO	NULL			
karyawan	3	created_by	int(11)	NO	NULL			
karyawan	4	updated_at	datetime	YES	NULL			
karyawan	5	updated_by	int(11)	YES	NULL			
karyawan	6	nik	varchar(50)	YES	NULL			
karyawan	7	nm_karyawan	varchar(255)	NO	NULL			
karyawan	8	kecamatan_id	int(11) unsigned	YES	1	MUL		
karyawan	9	alamat	varchar(255)	NO	NULL			
karyawan	10	tempat_lahir	varchar(255)	YES	NULL			
karyawan	11	tgl_lahir	date	YES	NULL			
karyawan	12	agama	varchar(10)	YES	NULL			
karyawan	13	jenis_kelamin	varchar(10)	YES	NULL			
karyawan	14	no_telp	varchar(20)	YES	NULL			
karyawan	15	email	varchar(100)	YES	NULL			
karyawan	16	jabatan_id	int(11) unsigned	YES	NULL	MUL		
karyawan	17	tgl_mulai_masuk	date	YES	NULL			
karyawan	18	status_karyawan	tinyint(1)	YES	1	MUL		
karyawan	19	cabang_id	int(11)	YES	NULL	MUL		
karyawan	20	gaji_pokok	int(11)	YES	NULL			
karyawan	21	nm_bank	varchar(255)	YES	NULL			
karyawan	22	no_rekening	varchar(255)	YES	NULL			
karyawan	23	atas_nama	varchar(255)	YES	NULL			
karyawan	24	is_deleted	tinyint(2)	NO	0			
karyawan	25	gambar_qrcode	text	YES	NULL			
karyawan	26	gambar_qrcode_mtek	text	NO	NULL			
karyawan	27	is_karyawan_tetap	tinyint(4)	NO	NULL			
karyawan	28	is_karyawan_gnet	int(11)	NO	1			
karyawan	29	no_sk_ketetapan	text	NO	NULL			
kas	1	id_kas	int(11) unsigned	NO	NULL	PRI	auto_increment	
kas	2	created_at	datetime	NO	NULL			
kas	3	created_by	int(11)	NO	NULL			
kas	4	updated_at	datetime	YES	NULL			
kas	5	updated_by	int(11)	YES	NULL			
kas	6	kd_kas	varchar(50)	YES	NULL			
kas	7	tgl_kas	datetime	NO	NULL			
kas	8	cabang_id	int(11) unsigned	YES	NULL	MUL		
kas	9	coa_id	int(20) unsigned	NO	NULL	MUL		
kas	10	type	char(1)	YES	NULL			
kas	11	karyawan_penerima_id	int(10) unsigned	YES	NULL	MUL		
kas	12	keterangan	text	YES	NULL			
kas	13	total	decimal(16,2)	YES	NULL			
kas	14	status_approval	tinyint(10)	YES	0			
kas	15	tgl_approval	date	YES	NULL			
kas	16	keterangan_approval	text	YES	NULL			
kas	17	karyawan_approval_id	int(10) unsigned	YES	NULL	MUL		
kas	18	tgl_batal	date	YES	NULL			
kas	19	keterangan_batal	text	YES	NULL			
kas	20	nm_penerima	varchar(255)	YES	NULL			
kas	21	alamat_penerima	text	YES	NULL			
kas	22	asal_kas	varchar(5)	YES	NULL			
kas	23	is_kas	tinyint(4)	YES	1	MUL		
kas	24	gambar1	text	YES	NULL			
kas	25	gambar2	text	YES	NULL			
kas	26	gambar3	text	YES	NULL			
kas	27	gambar4	text	YES	NULL			
kas	28	gambar5	text	YES	NULL			
kas	29	bukti	varchar(100)	YES	NULL			
kas	30	proyek_id	int(11)	NO	NULL			
kas_detail	1	id_kas_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
kas_detail	2	created_at	datetime	YES	NULL			
kas_detail	3	created_by	int(11)	YES	NULL			
kas_detail	4	updated_at	datetime	YES	NULL			
kas_detail	5	updated_by	int(11)	YES	NULL			
kas_detail	6	kas_id	bigint(20) unsigned	NO	NULL	MUL		
kas_detail	7	coa_detail_id	bigint(20) unsigned	YES	1	MUL		
kas_detail	8	type	enum('C','D')	YES	NULL			
kas_detail	9	nilai	decimal(16,2)	YES	0.00			
kas_detail	10	keterangan_detail	text	YES	NULL			
kas_retail	1	id_kas_retail	int(10) unsigned	NO	NULL	PRI	auto_increment	
kas_retail	2	created_at	datetime	NO	NULL			
kas_retail	3	created_by	int(11)	NO	NULL			
kas_retail	4	updated_at	datetime	YES	NULL			
kas_retail	5	updated_by	int(11)	YES	NULL			
kas_retail	6	kd_kas_retail	varchar(50)	YES	NULL	UNI		
kas_retail	7	tgl_kas_retail	datetime	YES	NULL	MUL		
kas_retail	8	nilai_bayar	int(11)	YES	NULL			
kas_retail	9	cabang_id	int(11)	YES	NULL			
kas_retail	10	nm_penerima	text	YES	NULL			
kas_retail	11	keterangan	text	NO	NULL			
kas_retail	12	bukti_bayar	text	NO	NULL			
kas_retail	13	status_approve	int(11)	YES	NULL			
kas_retail	14	tgl_approve	datetime	YES	NULL			
kas_retail	15	keterangan_approve	text	YES	NULL			
kas_retail	16	karyawan_approve_id	int(11)	YES	NULL			
kas_retail	17	is_full_gnet	tinyint(1)	NO	0			
kas_retail	18	tgl_batal	date	YES	NULL			
kas_retail	19	keterangan_batal	text	NO	NULL			
kas_retail	20	type	enum('C','D')	NO	NULL			
kategori_aset	1	id_kategori_aset	int(10) unsigned	NO	NULL	PRI	auto_increment	
kategori_aset	2	created_at	datetime	NO	NULL			
kategori_aset	3	created_by	int(11)	NO	NULL			
kategori_aset	4	updated_at	datetime	YES	NULL			
kategori_aset	5	updated_by	int(11)	YES	NULL			
kategori_aset	6	kd_kategori_aset	varchar(50)	YES	NULL	UNI		
kategori_aset	7	nm_kategori_aset	varchar(255)	YES	NULL	MUL		
kategori_aset	8	is_aktif	int(11)	YES	NULL			
kategori_aset	9	is_radio	tinyint(1)	NO	NULL			
kategori_aset	10	is_wifi	tinyint(1)	NO	NULL			
kategori_aset	11	is_ont	tinyint(1)	NO	NULL			
kategori_produk	1	id_kategori	int(10) unsigned	NO	NULL	PRI	auto_increment	
kategori_produk	2	created_at	datetime	NO	NULL			
kategori_produk	3	created_by	int(11)	NO	NULL			
kategori_produk	4	updated_at	datetime	YES	NULL			
kategori_produk	5	updated_by	int(11)	YES	NULL			
kategori_produk	6	kd_kategori	varchar(50)	YES	NULL	UNI		
kategori_produk	7	nm_kategori	varchar(255)	NO	NULL			
kecamatan	1	id_kecamatan	int(10) unsigned	NO	NULL	PRI	auto_increment	
kecamatan	2	created_at	datetime	NO	NULL			
kecamatan	3	created_by	int(11)	NO	NULL			
kecamatan	4	updated_at	datetime	YES	NULL			
kecamatan	5	updated_by	int(11)	YES	NULL			
kecamatan	6	nm_kecamatan	varchar(255)	NO	NULL			
kecamatan	7	status_kecamatan	tinyint(1)	YES	1			
kecamatan	8	kota_id	int(11)	NO	NULL	MUL		
kelurahan	1	id_kelurahan	int(11) unsigned	NO	NULL	PRI	auto_increment	
kelurahan	2	created_at	datetime	NO	NULL			
kelurahan	3	created_by	int(11)	NO	NULL			
kelurahan	4	updated_at	datetime	YES	NULL			
kelurahan	5	updated_by	int(11)	YES	NULL			
kelurahan	6	nm_kelurahan	varchar(255)	NO	NULL			
kelurahan	7	status_kelurahan	tinyint(1)	YES	1			
kelurahan	8	kecamatan_id	int(11)	NO	NULL	MUL		
kota	1	id_kota	int(10) unsigned	NO	NULL	PRI	auto_increment	
kota	2	created_at	datetime	NO	NULL			
kota	3	created_by	int(11)	NO	NULL			
kota	4	updated_at	datetime	YES	NULL			
kota	5	updated_by	int(11)	YES	NULL			
kota	6	nm_kota	varchar(255)	NO	NULL			
kota	7	status_kota	tinyint(1)	YES	1			
kota	8	provinsi_id	int(11)	NO	NULL	MUL		
level	1	id_level	int(11)	NO	NULL	PRI	auto_increment	
level	2	nm_level	varchar(200)	NO	NULL			
level	3	created_by	varchar(200)	NO	NULL			
level	4	created_date	datetime	NO	NULL			
level_menu	1	id_level_menu	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
level_menu	2	level_id	bigint(20) unsigned	NO	NULL	MUL		
level_menu	3	menu_id	varchar(50)	NO	NULL	MUL		
level_menu	4	created_by	varchar(200)	NO	NULL			
level_menu	5	created_date	datetime	NO	NULL			
log_mikrotik	1	id_log	bigint(20)	NO	NULL	PRI	auto_increment	
log_mikrotik	2	created_at	datetime	NO	current_timestamp()			
log_mikrotik	3	pesan	text	NO	NULL			
log_mikrotik	4	ip	text	NO	NULL			
log_mikrotik	5	status_kirim	int(11)	NO	0			
master	1	id_master	int(11) unsigned	NO	NULL	PRI	auto_increment	
master	2	created_at	datetime	NO	NULL			
master	3	created_by	int(11)	NO	NULL			
master	4	updated_at	datetime	YES	NULL			
master	5	updated_by	int(11)	YES	NULL			
master	6	nama	varchar(255)	NO	NULL			
master	7	group_master_id	int(11) unsigned	NO	NULL	MUL		
master	8	kode	varchar(255)	YES	NULL			
master	9	status	tinyint(1)	YES	1			
master	10	req_customer	varchar(10)	YES	NULL			
master	11	req_hasil	varchar(10)	YES	NULL			
master	12	req_tipe	varchar(10)	YES	NULL			
master	13	req_warna	varchar(10)	YES	NULL			
master	14	req_so	varchar(10)	YES	NULL			
master	15	jenis_account	varchar(20)	YES	NULL			
master	16	model_sales	tinyint(1)	YES	0	MUL		
master	17	is_ap	tinyint(1)	YES	0	MUL		
master	18	nilai_min_materai	decimal(10,0)	YES	NULL			
master	19	nilai_max_materai	decimal(10,0)	YES	NULL			
master	20	nilai_materai	decimal(10,0)	YES	NULL			
master	21	is_ar	tinyint(4)	YES	NULL	MUL		
master	22	jenis_cabang	varchar(1)	YES	NULL			
master	23	is_tagih	tinyint(1)	YES	0	MUL		
master	24	is_asuransi	tinyint(1)	YES	0	MUL		
master	25	model_kendaraan_sub_id	int(11)	YES	NULL			
master	26	syarat_jabatan	text	NO	NULL			
meeting	1	id_meeting	int(10) unsigned	NO	NULL	PRI	auto_increment	
meeting	2	created_at	datetime	NO	NULL			
meeting	3	created_by	int(11)	NO	NULL			
meeting	4	updated_at	datetime	YES	NULL			
meeting	5	updated_by	int(11)	YES	NULL			
meeting	6	kd_meeting	varchar(50)	YES	NULL			
meeting	7	tgl_meeting	date	YES	NULL			
meeting	8	keterangan	text	YES	NULL			
meeting	9	peserta_tidak_hadir	text	YES	NULL			
meeting	10	cabang_id	int(11)	NO	1			
member_tickets	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
member_tickets	2	ticket_number	varchar(50)	NO	NULL	UNI		
member_tickets	3	id_pelanggan	bigint(20) unsigned	NO	NULL	MUL		
member_tickets	4	category	varchar(50)	NO	NULL			
member_tickets	5	subject	varchar(200)	NO	NULL			
member_tickets	6	description	text	NO	NULL			
member_tickets	7	status	enum('open','in_progress','closed')	NO	'open'	MUL		
member_tickets	8	last_reply_at	timestamp	YES	NULL			
member_tickets	9	closed_at	timestamp	YES	NULL			
member_tickets	10	closed_by	varchar(100)	YES	NULL			
member_tickets	11	closing_note	text	YES	NULL			
member_tickets	12	created_at	timestamp	YES	NULL	MUL		
member_tickets	13	updated_at	timestamp	YES	NULL			
member_ticket_messages	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
member_ticket_messages	2	ticket_id	bigint(20) unsigned	NO	NULL	MUL		
member_ticket_messages	3	sender_name	varchar(100)	NO	NULL			
member_ticket_messages	4	is_staff	tinyint(1)	NO	0			
member_ticket_messages	5	message	text	NO	NULL			
member_ticket_messages	6	created_at	timestamp	YES	NULL	MUL		
member_ticket_messages	7	updated_at	timestamp	YES	NULL			
member_tokens	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
member_tokens	2	pelanggan_id	bigint(20) unsigned	NO	NULL	MUL		
member_tokens	3	token	varchar(500)	NO	NULL	UNI		
member_tokens	4	created_at	timestamp	NO	current_timestamp()			
member_tokens	5	expires_at	timestamp	YES	NULL			
member_tokens	6	ip_address	varchar(45)	YES	NULL			
member_tokens	7	user_agent	text	YES	NULL			
menu	1	nama	varchar(100)	NO	NULL			
menu	2	menu_id	varchar(30)	NO	NULL	PRI		
menu	3	status_menu	tinyint(4)	NO	1			
migrasi_radio_fo	1	id_migrasi	int(10) unsigned	NO	NULL	PRI	auto_increment	
migrasi_radio_fo	2	created_at	datetime	NO	NULL			
migrasi_radio_fo	3	created_by	int(11)	NO	NULL			
migrasi_radio_fo	4	updated_at	datetime	YES	NULL			
migrasi_radio_fo	5	updated_by	int(11)	YES	NULL			
migrasi_radio_fo	6	kd_migrasi	varchar(50)	YES	NULL	UNI		
migrasi_radio_fo	7	tgl_migrasi	varchar(255)	YES	NULL			
migrasi_radio_fo	8	pelanggan_id	varchar(255)	YES	NULL	MUL		
migrasi_radio_fo	9	cabang_id	int(11)	YES	NULL			
migrasi_radio_fo	10	keterangan	text	YES	NULL			
migrasi_radio_fo	11	aset_rl_id_old	int(11)	YES	NULL			
migrasi_radio_fo	12	aset_wifi_id_old	int(11)	YES	NULL			
migrasi_radio_fo	13	aset_ont_id_new	int(11)	YES	NULL			
migrations	1	id	int(10) unsigned	NO	NULL	PRI	auto_increment	
migrations	2	migration	varchar(255)	NO	NULL			
migrations	3	batch	int(11)	NO	NULL			
monitoring_nms	1	id_monitoring	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
monitoring_nms	2	created_at	datetime	NO	NULL			
monitoring_nms	3	created_by	int(11)	NO	NULL			
monitoring_nms	4	updated_at	datetime	YES	NULL			
monitoring_nms	5	updated_by	int(11)	YES	NULL			
monitoring_nms	6	kd_monitoring	varchar(50)	YES	NULL	UNI		
monitoring_nms	7	shift	varchar(255)	YES	NULL			
monitoring_nms	8	waktu	varchar(255)	YES	NULL			
monitoring_nms	9	tgl_monitoring	datetime	NO	NULL			
monitoring_nms	10	karyawan_user_id	int(10) unsigned	NO	NULL	MUL		
monitoring_nms	11	keterangan	text	YES	NULL			
monitoring_nms	12	bukti_upload	text	YES	NULL			
monitoring_nms	13	jumlah_sensor_merah	int(11)	NO	NULL			
monitor_kuota	1	id_monitor	bigint(20)	NO	NULL	PRI	auto_increment	
monitor_kuota	2	tgl_monitor	date	NO	NULL			
monitor_kuota	3	no_hp	varchar(255)	NO	NULL			
monitor_kuota	4	kapasitas	varchar(100)	NO	NULL			
monitor_kuota	5	customer_id	int(11)	NO	NULL			
monitor_kuota	6	created_by	int(11)	NO	NULL			
monitor_kuota	7	created_at	datetime	NO	NULL			
nas	1	id	int(11)	NO	NULL	PRI	auto_increment	
nas	2	nasname	varchar(128)	NO	NULL			
nas	3	shortname	varchar(32)	YES	NULL			
nas	4	type	varchar(30)	YES	'other'			
nas	5	ports	int(11)	YES	NULL			
nas	6	secret	varchar(60)	NO	'secret'			
nas	7	server	varchar(64)	YES	NULL			
nas	8	community	varchar(50)	YES	NULL			
nas	9	description	varchar(200)	YES	'RADIUS Client'			
nas	10	coa_server	enum('yes','no')	YES	'no'			
nas	11	nas_ip	varchar(255)	YES	NULL			
nas	12	api_port	varchar(255)	YES	NULL			
nas	13	api_user	varchar(255)	YES	NULL			
nas	14	api_pass	varchar(255)	YES	NULL			
nas	15	is_active	varchar(255)	YES	NULL			
notifikasi	1	id_notifikasi	int(11)	NO	NULL	PRI	auto_increment	
notifikasi	2	judul	varchar(255)	NO	NULL			
notifikasi	3	isi	text	NO	NULL			
notifikasi	4	tipe	enum('promo','pemeliharaan','tagihan','sistem')	NO	'sistem'			
notifikasi	5	target_pelanggan_id	int(11)	YES	NULL	MUL		
notifikasi	6	is_read	tinyint(1)	NO	0			
notifikasi	7	link	varchar(255)	YES	NULL			
notifikasi	8	created_at	datetime	NO	NULL			
notifikasi	9	created_by	int(11)	NO	NULL			
notifikasi	10	updated_at	datetime	YES	NULL			
notifikasi	11	updated_by	int(11)	YES	NULL			
odc	1	id_odc	int(10) unsigned	NO	NULL	PRI	auto_increment	
odc	2	created_at	datetime	NO	NULL			
odc	3	created_by	int(11)	NO	NULL			
odc	4	updated_at	datetime	YES	NULL			
odc	5	updated_by	int(11)	YES	NULL			
odc	6	kd_odc	varchar(50)	YES	NULL	UNI		
odc	7	latitude	varchar(255)	YES	NULL	MUL		
odc	8	longitude	varchar(255)	YES	NULL			
odc	9	cabang_id	int(11)	YES	NULL			
odc	10	alamat	text	YES	NULL			
odc	11	olt_id	int(11)	YES	NULL			
odc	12	kapasitas	int(11)	YES	NULL			
odc	13	status	varchar(255)	YES	NULL			
odc	14	keterangan	text	YES	NULL			
odp	1	id_odp	int(10) unsigned	NO	NULL	PRI	auto_increment	
odp	2	created_at	datetime	NO	NULL			
odp	3	created_by	int(11)	NO	NULL			
odp	4	updated_at	datetime	YES	NULL			
odp	5	updated_by	int(11)	YES	NULL			
odp	6	kd_odp	varchar(50)	YES	NULL	UNI		
odp	7	latitude	varchar(255)	YES	NULL	MUL		
odp	8	longitude	varchar(255)	YES	NULL			
odp	9	cabang_id	int(11)	YES	NULL			
odp	10	alamat	text	YES	NULL			
odp	11	odc_id	int(11)	YES	NULL			
odp	12	splitter_id	int(11)	YES	NULL			
odp	13	status	varchar(100)	NO	NULL			
olt	1	id_olt	int(10) unsigned	NO	NULL	PRI	auto_increment	
olt	2	created_at	datetime	NO	NULL			
olt	3	created_by	int(11)	NO	NULL			
olt	4	updated_at	datetime	YES	NULL			
olt	5	updated_by	int(11)	YES	NULL			
olt	6	kd_olt	varchar(255)	YES	NULL	UNI		
olt	7	jumlah_pon	int(11)	NO	NULL			
olt	8	latitude	varchar(255)	YES	NULL	MUL		
olt	9	longitude	varchar(255)	YES	NULL			
olt	10	cabang_id	int(11)	YES	NULL			
olt	11	alamat	text	YES	NULL			
olt	12	keterangan	varchar(255)	YES	NULL			
olt	13	jenis_olt_id	int(11)	YES	NULL			
olt	14	merek_olt	varchar(255)	YES	NULL			
olt	15	foto_olt	text	YES	NULL			
orders	1	id	int(11)	NO	NULL	PRI	auto_increment	
orders	2	order_id	varchar(50)	NO	NULL	UNI		
orders	3	pelanggan_id	int(11)	NO	NULL	MUL		
orders	4	invoice_id	int(11)	NO	NULL	MUL		
orders	5	gross_amount	decimal(15,2)	NO	NULL			
orders	6	status	varchar(20)	YES	'pending'			
orders	7	snap_token	varchar(255)	YES	NULL			
orders	8	snap_url	varchar(255)	YES	NULL			
orders	9	created_at	datetime	NO	NULL			
orders	10	updated_at	datetime	YES	NULL			
password_reset_tokens	1	email	varchar(255)	NO	NULL	PRI		
password_reset_tokens	2	token	varchar(255)	NO	NULL			
password_reset_tokens	3	created_at	timestamp	YES	NULL			
payments	1	id	int(11)	NO	NULL	PRI	auto_increment	
payments	2	order_id	varchar(50)	NO	NULL	MUL		
payments	3	transaction_id	varchar(100)	YES	NULL			
payments	4	payment_type	varchar(50)	YES	NULL			
payments	5	status	varchar(50)	YES	NULL			
payments	6	fraud_status	varchar(50)	YES	NULL			
payments	7	transaction_time	datetime	YES	NULL			
payments	8	settlement_time	datetime	YES	NULL			
payments	9	raw_response	text	YES	NULL			
payments	10	signature_key	varchar(255)	YES	NULL			
payments	11	created_at	datetime	NO	NULL			
payments	12	updated_at	datetime	YES	NULL			
pelanggan	1	id_pelanggan	int(10) unsigned	NO	NULL	PRI	auto_increment	
pelanggan	2	created_at	datetime	NO	NULL			
pelanggan	3	created_by	int(11)	NO	NULL			
pelanggan	4	updated_at	datetime	YES	NULL			
pelanggan	5	updated_by	int(11)	YES	NULL			
pelanggan	6	kd_pelanggan	varchar(50)	YES	NULL			
pelanggan	7	nik	varchar(50)	YES	NULL			
pelanggan	8	no_layanan	varchar(100)	YES	NULL	UNI		
pelanggan	9	cabang_id	int(11)	YES	NULL			
pelanggan	10	tgl_pesanan	date	YES	NULL			
pelanggan	11	nm_pelanggan	varchar(255)	NO	NULL			
pelanggan	12	alamat_identitas	text	YES	NULL			
pelanggan	13	no_telp	varchar(30)	YES	NULL			
pelanggan	14	email	varchar(255)	YES	NULL			
pelanggan	15	produk_id	int(11)	YES	NULL			
pelanggan	16	alamat_instalasi	varchar(255)	YES	NULL			
pelanggan	17	biaya_instalasi	int(11)	YES	NULL			
pelanggan	18	marketer_id	int(11)	YES	NULL			
pelanggan	19	teknisi_id	int(11)	YES	NULL			
pelanggan	20	alamat	text	YES	NULL			
pelanggan	21	id_pppoe	text	YES	NULL			
pelanggan	22	sn_ont	text	YES	NULL			
pelanggan	23	odp_id	int(11)	YES	NULL			
pelanggan	24	redaman	varchar(255)	YES	NULL			
pelanggan	25	tgl_aktivasi	datetime	YES	NULL			
pelanggan	26	ssid_wifi	text	YES	NULL			
pelanggan	27	password_wifi	text	YES	NULL			
pelanggan	28	panjang_kabel	varchar(255)	YES	NULL			
pelanggan	29	kecamatan_id	int(11)	YES	NULL			
pelanggan	30	komisi	int(11)	YES	0			
pelanggan	31	is_radio	tinyint(4)	YES	NULL			
pelanggan	32	sn_rl	varchar(255)	YES	NULL			
pelanggan	33	sn_wifi	varchar(255)	YES	NULL			
pelanggan	34	ip_rl	varchar(255)	YES	NULL			
pelanggan	35	ip_modem	varchar(255)	YES	NULL			
pelanggan	36	facing_ap	varchar(255)	YES	NULL			
pelanggan	37	harga_jual	int(11)	NO	NULL			
pelanggan	38	biaya_teknisi	int(11)	YES	0			
pelanggan	39	aset_rl_id	int(11)	YES	NULL			
pelanggan	40	aset_wifi_id	int(11)	YES	NULL			
pelanggan	41	keterangan	text	YES	NULL			
pelanggan	42	tgl_bayar_otc	datetime	YES	NULL			
pelanggan	43	nilai_bayar_otc	int(11)	NO	0			
pelanggan	44	via_bayar_otc	varchar(255)	YES	NULL			
pelanggan	45	keterangan_bayar_otc	text	YES	NULL			
pelanggan	46	bukti_bayar_otc	text	YES	NULL			
pelanggan	47	karyawan_penerima_id	int(11)	YES	NULL			
pelanggan	48	is_setor_kantor	tinyint(1)	NO	0			
pelanggan	49	latitude	text	YES	NULL			
pelanggan	50	longitude	text	YES	NULL			
pelanggan	51	aset_ont_id	int(11)	YES	NULL			
pelanggan	52	status_aktif	tinyint(1)	NO	1			
pelanggan	53	tgl_batal	date	YES	NULL			
pelanggan	54	keterangan_batal	text	YES	NULL			
pelanggan	55	is_no_valid	tinyint(1)	YES	NULL			
pelanggan	56	status	varchar(100)	YES	NULL			
pelanggan	57	radusergroup_id	int(11)	YES	NULL			
pelanggan	58	upload_ktp	text	YES	NULL			
pelanggan	59	password_pppoe	text	YES	NULL			
pelanggan	60	no_order_tif	varchar(255)	YES	NULL			
pelanggan	61	marketer2_id	int(11)	YES	NULL			
pelanggan	62	komisi_marketer2	int(11)	YES	NULL			
pelanggan	63	marketer3_id	int(11)	YES	NULL			
pelanggan	64	komisi_marketer3	int(11)	YES	NULL			
penerimaan_pembayaran_retail	1	id_penerimaan	int(10) unsigned	NO	NULL	PRI	auto_increment	
penerimaan_pembayaran_retail	2	created_at	datetime	NO	NULL			
penerimaan_pembayaran_retail	3	created_by	int(11)	YES	NULL			
penerimaan_pembayaran_retail	4	updated_at	datetime	YES	NULL			
penerimaan_pembayaran_retail	5	updated_by	int(11)	YES	NULL			
penerimaan_pembayaran_retail	6	kd_penerimaan	varchar(50)	YES	NULL	UNI		
penerimaan_pembayaran_retail	7	tgl_penerimaan	datetime	YES	NULL			
penerimaan_pembayaran_retail	8	invoice_id	bigint(20)	YES	NULL	MUL		
penerimaan_pembayaran_retail	9	nilai_bayar	int(11)	YES	NULL			
penerimaan_pembayaran_retail	10	cabang_id	int(11)	YES	NULL			
penerimaan_pembayaran_retail	11	via_bayar	varchar(255)	YES	NULL			
penerimaan_pembayaran_retail	12	keterangan	text	YES	NULL			
penerimaan_pembayaran_retail	13	sumber_data	text	YES	NULL			
penerimaan_pembayaran_retail	14	tgl_batal	datetime	YES	NULL			
penerimaan_pembayaran_retail	15	keterangan_batal	text	YES	NULL			
penerimaan_pembayaran_retail	16	karyawan_penerima_id	int(11)	YES	NULL			
pesan_item	1	id_pesan	int(11) unsigned	NO	NULL	PRI	auto_increment	
pesan_item	2	created_at	datetime	NO	NULL			
pesan_item	3	created_by	int(11)	NO	NULL			
pesan_item	4	updated_at	datetime	YES	NULL			
pesan_item	5	updated_by	int(11)	YES	NULL			
pesan_item	6	kd_pesan	varchar(30)	YES	NULL			
pesan_item	7	tgl_pesan	date	NO	NULL			
pesan_item	8	cabang_id	int(11) unsigned	YES	NULL	MUL		
pesan_item	9	product_pesan_id	tinyint(4)	NO	NULL	MUL		
pesan_item	10	type_pesan	tinyint(4) unsigned	YES	NULL			
pesan_item	11	vendor_id	int(11) unsigned	YES	NULL	MUL		
pesan_item	12	vendor_cabang_id	int(11) unsigned	YES	NULL	MUL		
pesan_item	13	gudang_pesan_id	int(11)	YES	NULL	MUL		
pesan_item	14	status	tinyint(4)	YES	NULL			
pesan_item	15	tgl_batal	date	YES	NULL			
pesan_item	16	keterangan_batal	varchar(255)	YES	NULL			
pesan_item	17	status_pesan	tinyint(4)	YES	1			
pesan_item	18	status_transfer	tinyint(4)	YES	1			
pesan_item	19	status_approve	tinyint(1)	YES	0			
pesan_item	20	keterangan_approve	text	YES	NULL			
pesan_item	21	tgl_approve	date	YES	NULL			
pesan_item	22	karyawan_approve_id	int(11)	YES	NULL	MUL		
pesan_item	23	pesan_cabang	tinyint(4)	YES	0			
pesan_item	24	cabang_vendor_id	int(11)	YES	NULL	MUL		
pesan_item	25	status_approve_ho	tinyint(4)	YES	0			
pesan_item	26	keterangan_approve_ho	text	YES	NULL			
pesan_item	27	tgl_approve_ho	date	YES	NULL			
pesan_item	28	karyawan_approve_ho_id	int(11)	YES	NULL	MUL		
pesan_item	29	tipe_pesanan	varchar(20)	YES	NULL			
pesan_item_detail	1	id_pesan_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
pesan_item_detail	2	created_at	datetime	NO	NULL			
pesan_item_detail	3	created_by	int(11)	NO	NULL			
pesan_item_detail	4	updated_at	datetime	YES	NULL			
pesan_item_detail	5	updated_by	int(11)	YES	NULL			
pesan_item_detail	6	pesan_id	bigint(20) unsigned	NO	NULL	MUL		
pesan_item_detail	7	product_id	bigint(20) unsigned	YES	1	MUL		
pesan_item_detail	8	harga	decimal(10,0)	YES	0			
pesan_item_detail	9	qty	decimal(10,2)	YES	0.00			
pesan_item_detail	10	qty_terima	decimal(10,2)	YES	0.00			
pesan_item_detail	11	qty_transfer_stok	decimal(10,2)	YES	0.00			
po	1	id_po	int(11)	NO	NULL	PRI	auto_increment	
po	2	cabang	varchar(255)	NO	NULL			
po	3	kode	varchar(255)	NO	NULL			
po	4	nm_toko	varchar(255)	NO	NULL			
po	5	tikor	text	NO	NULL			
po	6	alamat	text	NO	NULL			
po	7	kecamatan_id	int(11)	NO	NULL			
po	8	nm_kelurahan	text	NO	NULL			
pop	1	id_pop	int(10) unsigned	NO	NULL	PRI	auto_increment	
pop	2	created_at	datetime	NO	NULL			
pop	3	created_by	int(11)	NO	NULL			
pop	4	updated_at	datetime	YES	NULL			
pop	5	updated_by	int(11)	YES	NULL			
pop	6	kd_pop	varchar(50)	YES	NULL	UNI		
pop	7	nm_pop	varchar(255)	YES	NULL			
pop	8	latitude	varchar(255)	YES	NULL	MUL		
pop	9	longitude	varchar(255)	YES	NULL			
pop	10	cabang_id	int(11)	YES	NULL			
pop	11	alamat	text	YES	NULL			
pop	12	keterangan	int(11)	YES	NULL			
pop	13	tinggi	varchar(255)	NO	NULL			
product	1	id_product	bigint(11) unsigned	NO	NULL	PRI	auto_increment	
product	2	created_at	datetime	NO	NULL			
product	3	created_by	int(11)	NO	NULL			
product	4	updated_at	datetime	YES	NULL			
product	5	updated_by	int(11)	YES	NULL			
product	6	kd_product	varchar(50)	YES	NULL	UNI		
product	7	nm_product	varchar(255)	NO	NULL			
product	8	group_product_id	int(255) unsigned	NO	NULL	MUL		
product	9	harga_beli	decimal(10,0)	YES	0			
product	10	harga_jual	decimal(10,0)	YES	0			
product	11	satuan_id	int(11) unsigned	YES	NULL	MUL		
product	12	status_product	tinyint(1)	YES	1			
product	13	is_otc	tinyint(3)	NO	0			
product	14	is_fo	int(11)	YES	NULL			
produk	1	id_produk	int(10) unsigned	NO	NULL	PRI	auto_increment	
produk	2	created_at	datetime	NO	NULL			
produk	3	created_by	int(11)	NO	NULL			
produk	4	updated_at	datetime	YES	NULL			
produk	5	updated_by	int(11)	YES	NULL			
produk	6	kd_produk	varchar(50)	YES	NULL	UNI		
produk	7	nm_produk	varchar(255)	NO	NULL			
produk	8	kategori_produk_id	int(11)	YES	NULL			
produk	9	harga_jual	int(11)	YES	NULL			
produk	10	cabang_id	int(11)	NO	NULL			
produk	11	bw_mikrotik	varchar(100)	YES	NULL			
provinces	1	id	char(2)	NO	NULL	PRI		
provinces	2	name	varchar(255)	NO	NULL			
provinces	3	status_provinsi	int(11)	NO	NULL			
provinsi	1	id_provinsi	int(10) unsigned	NO	NULL	PRI	auto_increment	
provinsi	2	created_at	datetime	NO	NULL			
provinsi	3	created_by	int(11)	NO	NULL			
provinsi	4	updated_at	datetime	YES	NULL			
provinsi	5	updated_by	int(11)	YES	NULL			
provinsi	6	nm_provinsi	varchar(255)	NO	NULL			
provinsi	7	status_provinsi	tinyint(1)	YES	1			
proyek	1	id_proyek	int(11)	NO	NULL	PRI	auto_increment	
proyek	2	nm_proyek	varchar(255)	NO	NULL			
proyek	3	alamat_proyek	text	NO	NULL			
radacct	1	radacctid	bigint(20)	NO	NULL	PRI	auto_increment	
radacct	2	acctsessionid	varchar(64)	NO	''	MUL		
radacct	3	acctuniqueid	varchar(32)	NO	''	UNI		
radacct	4	username	varchar(64)	NO	''	MUL		
radacct	5	realm	varchar(64)	YES	''			
radacct	6	nasipaddress	varchar(15)	NO	''	MUL		
radacct	7	nasportid	varchar(32)	YES	NULL			
radacct	8	nasporttype	varchar(32)	YES	NULL			
radacct	9	acctstarttime	datetime	YES	NULL	MUL		
radacct	10	acctupdatetime	datetime	YES	NULL			
radacct	11	acctstoptime	datetime	YES	NULL	MUL		
radacct	12	acctinterval	int(11)	YES	NULL	MUL		
radacct	13	acctsessiontime	int(10) unsigned	YES	NULL	MUL		
radacct	14	acctauthentic	varchar(32)	YES	NULL			
radacct	15	connectinfo_start	varchar(128)	YES	NULL			
radacct	16	connectinfo_stop	varchar(128)	YES	NULL			
radacct	17	acctinputoctets	bigint(20)	YES	NULL			
radacct	18	acctoutputoctets	bigint(20)	YES	NULL			
radacct	19	calledstationid	varchar(50)	NO	''			
radacct	20	callingstationid	varchar(50)	NO	''			
radacct	21	acctterminatecause	varchar(32)	NO	''			
radacct	22	servicetype	varchar(32)	YES	NULL			
radacct	23	framedprotocol	varchar(32)	YES	NULL			
radacct	24	framedipaddress	varchar(15)	NO	''	MUL		
radacct	25	framedipv6address	varchar(45)	NO	''	MUL		
radacct	26	framedipv6prefix	varchar(45)	NO	''	MUL		
radacct	27	framedinterfaceid	varchar(44)	NO	''	MUL		
radacct	28	delegatedipv6prefix	varchar(45)	NO	''	MUL		
radacct	29	class	varchar(64)	YES	NULL	MUL		
radcheck	1	id	int(10) unsigned	NO	NULL	PRI	auto_increment	
radcheck	2	username	varchar(64)	NO	''	MUL		
radcheck	3	attribute	varchar(64)	NO	''			
radcheck	4	op	char(2)	NO	'=='			
radcheck	5	value	varchar(253)	NO	''			
radgroupcheck	1	id	int(10) unsigned	NO	NULL	PRI		
radgroupcheck	2	groupname	varchar(64)	NO	''	MUL		
radgroupcheck	3	attribute	varchar(64)	NO	''			
radgroupcheck	4	op	char(2)	NO	'=='			
radgroupcheck	5	value	varchar(253)	NO	''			
radgroupreply	1	id	int(10) unsigned	NO	NULL	PRI		
radgroupreply	2	groupname	varchar(64)	NO	''	MUL		
radgroupreply	3	attribute	varchar(64)	NO	''			
radgroupreply	4	op	char(2)	NO	'='			
radgroupreply	5	value	varchar(253)	NO	''			
radgroupreply	6	harga	int(11)	YES	NULL			
radpostauth	1	id	bigint(20)	NO	NULL	PRI	auto_increment	
radpostauth	2	username	varchar(64)	NO	''	MUL		
radpostauth	3	pass	varchar(64)	NO	''			
radpostauth	4	reply	varchar(32)	NO	''			
radpostauth	5	authdate	timestamp(6)	NO	current_timestamp(6)		on update current_timestamp(6)	
radpostauth	6	class	varchar(64)	YES	NULL	MUL		
radreply	1	id	int(10) unsigned	NO	NULL	PRI		
radreply	2	username	varchar(64)	NO	''	MUL		
radreply	3	attribute	varchar(64)	NO	''			
radreply	4	op	char(2)	NO	'='			
radreply	5	value	varchar(253)	NO	''			
radusergroup	1	id	int(10) unsigned	NO	NULL	PRI	auto_increment	
radusergroup	2	username	varchar(64)	NO	''	MUL		
radusergroup	3	groupname	varchar(64)	YES	NULL			
radusergroup	4	priority	int(11)	NO	1			
regencies	1	id	char(4)	NO	NULL	PRI		
regencies	2	province_id	char(2)	NO	NULL	MUL		
regencies	3	name	varchar(255)	NO	NULL			
rekap_invoice	1	id_rekap_invoice	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
rekap_invoice	2	created_at	datetime	NO	NULL			
rekap_invoice	3	created_by	int(11)	NO	NULL			
rekap_invoice	4	updated_at	datetime	YES	NULL			
rekap_invoice	5	updated_by	int(11)	YES	NULL			
rekap_invoice	6	kd_rekap_invoice	varchar(50)	NO	NULL	UNI		
rekap_invoice	7	tgl_rekap_invoice	date	NO	NULL			
rekap_invoice	8	periode_awal	date	YES	NULL	MUL		
rekap_invoice	9	periode_akhir	date	YES	NULL	MUL		
rekap_invoice	10	vendor_id	int(11) unsigned	YES	NULL	MUL		
rekap_invoice	11	cabang_id	int(11)	YES	NULL			
rekap_invoice	12	status	tinyint(4)	YES	NULL			
rekap_invoice	13	tgl_batal	date	YES	NULL			
rekap_invoice	14	keterangan_batal	varchar(255)	YES	NULL			
rekap_invoice	15	grand_total	decimal(10,0)	YES	0			
rekap_invoice	16	status_approval	tinyint(4)	YES	0			
rekap_invoice	17	tgl_approval	date	YES	NULL			
rekap_invoice	18	keterangan_approval	text	YES	NULL			
rekap_invoice	19	karyawan_approval_id	bigint(20)	YES	NULL			
rekap_invoice	20	keterangan	text	YES	NULL			
rekap_invoice_detail	1	id_rekap_invoice_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
rekap_invoice_detail	2	created_at	datetime	YES	NULL			
rekap_invoice_detail	3	created_by	int(11)	YES	NULL			
rekap_invoice_detail	4	updated_at	datetime	YES	NULL			
rekap_invoice_detail	5	updated_by	int(11)	YES	NULL			
rekap_invoice_detail	6	rekap_invoice_id	bigint(20)	YES	NULL			
rekap_invoice_detail	7	invoice_id	bigint(20) unsigned	NO	NULL	MUL		
rekap_invoice_detail	8	total	decimal(10,0)	YES	NULL			
reminder_invoice	1	id_reminder	int(10) unsigned	NO	NULL	PRI	auto_increment	
reminder_invoice	2	created_at	datetime	NO	NULL			
reminder_invoice	3	created_by	int(11)	NO	NULL			
reminder_invoice	4	updated_at	datetime	YES	NULL			
reminder_invoice	5	updated_by	int(11)	YES	NULL			
reminder_invoice	6	kd_reminder	varchar(50)	YES	NULL	UNI		
reminder_invoice	7	tgl_reminder	datetime	YES	NULL			
reminder_invoice	8	invoice_id	int(11)	YES	NULL			
reminder_invoice	9	via_reminder	varchar(255)	YES	NULL			
reminder_invoice	10	cabang_id	int(11)	YES	NULL			
reminder_invoice	11	keterangan	text	YES	NULL			
reminder_recipients	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
reminder_recipients	2	bulk_reminder_id	bigint(20) unsigned	NO	NULL	MUL		
reminder_recipients	3	invoice_id	int(11)	NO	NULL			
reminder_recipients	4	pelanggan_id	bigint(20) unsigned	YES	NULL			
reminder_recipients	5	customer_name	varchar(255)	NO	NULL			
reminder_recipients	6	phone_number	varchar(255)	NO	NULL			
reminder_recipients	7	amount	decimal(15,2)	NO	NULL			
reminder_recipients	8	status	enum('pending','sent','failed','paid')	NO	'pending'			
reminder_recipients	9	payment_link	varchar(255)	YES	NULL			
reminder_recipients	10	midtrans_order_id	varchar(255)	YES	NULL			
reminder_recipients	11	sent_at	timestamp	YES	NULL			
reminder_recipients	12	error_message	text	YES	NULL			
reminder_recipients	13	created_at	timestamp	YES	NULL			
reminder_recipients	14	updated_at	timestamp	YES	NULL			
reminder_recipients	15	payment_status	varchar(255)	YES	NULL			
reminder_recipients	16	payment_date	datetime	YES	NULL			
reminder_recipients	17	payment_data	text	YES	NULL			
reseller_balance_transactions	1	id_transaction	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
reseller_balance_transactions	2	user_id	bigint(20) unsigned	NO	NULL	MUL		
reseller_balance_transactions	3	payment_id	varchar(100)	NO	NULL	UNI		
reseller_balance_transactions	4	transaction_type	enum('commission','withdrawal','adjustment','refun...	NO	NULL	MUL		
reseller_balance_transactions	5	amount	decimal(15,2)	NO	NULL			
reseller_balance_transactions	6	balance_before	decimal(15,2)	NO	NULL			
reseller_balance_transactions	7	balance_after	decimal(15,2)	NO	NULL			
reseller_balance_transactions	8	invoice_id	bigint(20) unsigned	YES	NULL	MUL		
reseller_balance_transactions	9	description	text	YES	NULL			
reseller_balance_transactions	10	status	enum('pending','completed','failed','cancelled')	NO	'completed'	MUL		
reseller_balance_transactions	11	processed_at	timestamp	YES	NULL			
reseller_balance_transactions	12	created_by	bigint(20) unsigned	YES	NULL			
reseller_balance_transactions	13	created_at	timestamp	YES	NULL	MUL		
reseller_balance_transactions	14	updated_at	timestamp	YES	NULL			
reseller_withdrawal_requests	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
reseller_withdrawal_requests	2	user_id	bigint(20) unsigned	NO	NULL	MUL		
reseller_withdrawal_requests	3	withdrawal_code	varchar(255)	NO	NULL	UNI		
reseller_withdrawal_requests	4	amount	decimal(15,2)	NO	NULL			
reseller_withdrawal_requests	5	status	enum('pending','approved','rejected','paid')	NO	'pending'	MUL		
reseller_withdrawal_requests	6	bank_name	varchar(255)	YES	NULL			
reseller_withdrawal_requests	7	account_number	varchar(255)	YES	NULL			
reseller_withdrawal_requests	8	account_holder	varchar(255)	YES	NULL			
reseller_withdrawal_requests	9	notes	text	YES	NULL			
reseller_withdrawal_requests	10	admin_notes	text	YES	NULL			
reseller_withdrawal_requests	11	approved_by	bigint(20) unsigned	YES	NULL	MUL		
reseller_withdrawal_requests	12	approved_at	timestamp	YES	NULL			
reseller_withdrawal_requests	13	paid_at	timestamp	YES	NULL			
reseller_withdrawal_requests	14	created_at	timestamp	YES	NULL			
reseller_withdrawal_requests	15	updated_at	timestamp	YES	NULL			
saldo_coa	1	id_saldo	int(11) unsigned	NO	NULL	PRI	auto_increment	
saldo_coa	2	created_at	datetime	NO	NULL			
saldo_coa	3	created_by	int(11)	NO	NULL			
saldo_coa	4	updated_at	datetime	YES	NULL			
saldo_coa	5	updated_by	int(11)	YES	NULL			
saldo_coa	6	fk_coa	varchar(20)	YES	NULL			
saldo_coa	7	tr_month	varchar(2)	NO	NULL			
saldo_coa	8	tr_year	varchar(4)	YES	'1'			
saldo_coa	9	saldo_d	decimal(10,0)	NO	0			
saldo_coa	10	saldo_c	decimal(11,0)	YES	0			
saldo_coa	11	balance_cash	decimal(11,0)	YES	0			
saldo_coa	12	balance_bank	decimal(10,2)	YES	0.00			
saldo_coa	13	balance_memorial	decimal(11,0)	YES	0			
saldo_coa	14	balance_gl_auto	decimal(11,0)	YES	0			
saldo_coa_cabang	1	id_saldo_cabang	int(11) unsigned	NO	NULL	PRI	auto_increment	
saldo_coa_cabang	2	created_at	datetime	NO	NULL			
saldo_coa_cabang	3	created_by	int(11)	NO	NULL			
saldo_coa_cabang	4	updated_at	datetime	YES	NULL			
saldo_coa_cabang	5	updated_by	int(11)	YES	NULL			
saldo_coa_cabang	6	fk_coa	varchar(20)	YES	NULL			
saldo_coa_cabang	7	tr_month	int(2)	NO	NULL			
saldo_coa_cabang	8	tr_year	int(4)	YES	1			
saldo_coa_cabang	9	saldo_d	decimal(10,0)	NO	0			
saldo_coa_cabang	10	saldo_c	decimal(11,0)	YES	0			
saldo_coa_cabang	11	balance_cash	decimal(11,0)	YES	0			
saldo_coa_cabang	12	balance_bank	decimal(10,2)	YES	0.00			
saldo_coa_cabang	13	balance_memorial	decimal(11,0)	YES	0			
saldo_coa_cabang	14	balance_gl_auto	decimal(11,0)	YES	0			
saldo_coa_cabang	15	cabang_id	int(11)	YES	NULL	MUL		
saldo_laba_rugi	1	id_saldo_laba_rugi	int(11) unsigned	NO	NULL	PRI	auto_increment	
saldo_laba_rugi	2	created_at	datetime	NO	NULL			
saldo_laba_rugi	3	created_by	int(11)	NO	NULL			
saldo_laba_rugi	4	updated_at	datetime	YES	NULL			
saldo_laba_rugi	5	updated_by	int(11)	YES	NULL			
saldo_laba_rugi	6	cabang_id	varchar(20)	YES	NULL			
saldo_laba_rugi	7	tr_month	int(2)	NO	NULL			
saldo_laba_rugi	8	tr_year	int(4)	YES	1			
saldo_laba_rugi	9	saldo	bigint(20)	NO	0			
saldo_laba_rugi	10	divisi	varchar(100)	YES	NULL			
sales_order	1	id_so	int(11) unsigned	NO	NULL	PRI	auto_increment	
sales_order	2	created_at	datetime	NO	NULL			
sales_order	3	created_by	int(11)	NO	NULL			
sales_order	4	updated_at	datetime	YES	NULL			
sales_order	5	updated_by	int(11)	YES	NULL			
sales_order	6	kd_so	varchar(30)	YES	NULL			
sales_order	7	tgl_so	date	NO	NULL			
sales_order	8	group_product_id	int(11)	YES	NULL	MUL		
sales_order	9	cabang_id	int(11) unsigned	YES	NULL	MUL		
sales_order	10	customer_id	bigint(20) unsigned	NO	NULL	MUL		
sales_order	11	no_po	varchar(100)	YES	NULL	MUL		
sales_order	12	status	tinyint(4)	YES	NULL			
sales_order	13	total_gross	decimal(10,0)	YES	NULL			
sales_order	14	total_ppn	decimal(10,0)	YES	NULL			
sales_order	15	total_diskon	decimal(10,0)	YES	NULL			
sales_order	16	grand_total	decimal(10,0)	YES	NULL			
sales_order	17	tgl_batal	date	YES	NULL			
sales_order	18	keterangan_batal	text	YES	NULL			
sales_order	19	is_ppn	tinyint(4)	YES	0			
sales_order	20	keterangan	text	YES	NULL			
sales_order	21	is_tutup	int(11)	NO	0			
sales_order_detail	1	id_sales_order_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
sales_order_detail	2	created_at	datetime	YES	NULL			
sales_order_detail	3	created_by	int(11)	YES	NULL			
sales_order_detail	4	updated_at	datetime	YES	NULL			
sales_order_detail	5	updated_by	int(11)	YES	NULL			
sales_order_detail	6	sales_order_id	bigint(20) unsigned	NO	NULL	MUL		
sales_order_detail	7	product_id	bigint(20) unsigned	YES	1	MUL		
sales_order_detail	8	harga	decimal(10,0)	YES	0			
sales_order_detail	9	qty	decimal(10,0)	YES	0			
sales_order_detail	10	diskon	decimal(10,0)	YES	0			
sales_order_detail	11	netto	decimal(10,0)	YES	0			
sales_order_detail	12	keterangan_detail	text	YES	NULL			
sales_order_detail	13	customer_detail_id	int(11)	YES	0			
satuan	1	id_satuan	int(11) unsigned	NO	NULL	PRI	auto_increment	
satuan	2	created_at	datetime	NO	NULL			
satuan	3	created_by	int(11)	NO	NULL			
satuan	4	updated_at	datetime	YES	NULL			
satuan	5	updated_by	int(11)	YES	NULL			
satuan	6	nm_satuan	varchar(255)	NO	NULL			
serial_transaksi_cabang	1	id_serial	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
serial_transaksi_cabang	2	created_at	datetime	YES	NULL			
serial_transaksi_cabang	3	created_by	int(11)	YES	NULL			
serial_transaksi_cabang	4	updated_at	datetime	YES	NULL			
serial_transaksi_cabang	5	updated_by	int(11)	YES	NULL			
serial_transaksi_cabang	6	cabang_id	varchar(255)	NO	NULL	MUL		
serial_transaksi_cabang	7	kd_transaksi	varchar(255)	NO	NULL			
serial_transaksi_cabang	8	bulan	varchar(20)	YES	NULL			
serial_transaksi_cabang	9	tahun	varchar(15)	YES	NULL			
serial_transaksi_cabang	10	counter	bigint(20)	YES	1			
sessions	1	id	varchar(255)	NO	NULL	PRI		
sessions	2	user_id	bigint(20) unsigned	YES	NULL	MUL		
sessions	3	ip_address	varchar(45)	YES	NULL			
sessions	4	user_agent	text	YES	NULL			
sessions	5	payload	longtext	NO	NULL			
sessions	6	last_activity	int(11)	NO	NULL	MUL		
sid	1	sid	varchar(255)	NO	NULL			
sosial_media	1	id_sosial_media	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
sosial_media	2	created_at	datetime	NO	NULL			
sosial_media	3	created_by	int(11)	NO	NULL			
sosial_media	4	updated_at	datetime	YES	NULL			
sosial_media	5	updated_by	int(11)	YES	NULL			
sosial_media	6	kd_posting	varchar(50)	YES	NULL	UNI		
sosial_media	7	tgl_posting	datetime	NO	NULL			
sosial_media	8	judul	varchar(255)	NO	NULL	MUL		
sosial_media	9	sumber	varchar(255)	YES	'0'			
sosial_media	10	link	text	YES	NULL			
splitter	1	id_splitter	int(10) unsigned	NO	NULL	PRI	auto_increment	
splitter	2	created_at	datetime	NO	NULL			
splitter	3	created_by	int(11)	NO	NULL			
splitter	4	updated_at	datetime	YES	NULL			
splitter	5	updated_by	int(11)	YES	NULL			
splitter	6	rasio	varchar(50)	YES	NULL	UNI		
splitter	7	jumlah_splitter	int(11)	NO	NULL			
splitter	8	core_input	int(11)	YES	NULL			
splitter	9	core_output	int(11)	YES	NULL			
stock	1	id_stock	bigint(20) unsigned	NO	NULL			
stock	2	created_at	datetime	NO	NULL			
stock	3	created_by	int(11)	NO	NULL			
stock	4	updated_at	datetime	YES	NULL			
stock	5	updated_by	int(11)	YES	NULL			
stock	6	product_id	bigint(20)	NO	NULL	PRI		
stock	7	cabang_id	int(10)	NO	NULL	PRI		
stock	8	bulan	varchar(5)	NO	NULL	PRI		
stock	9	tahun	varchar(5)	NO	NULL	PRI		
stock	10	gudang_id	tinyint(1)	NO	1	PRI		
stock	11	hpp_terakhir	decimal(10,2)	YES	0.00			
stock	12	on_hand	decimal(10,2)	YES	0.00			
stock	13	terima	decimal(10,2)	YES	0.00			
stock	14	on_order	decimal(10,2)	YES	0.00			
stock	15	on_iris_in	decimal(10,2)	YES	0.00			
stock	16	on_iris_out	decimal(10,2)	YES	0.00			
stock	17	on_demand	decimal(10,2)	YES	0.00			
stock	18	keluar	decimal(10,2)	YES	0.00			
stock	19	koreksi_in	decimal(10,2)	YES	0.00			
stock	20	koreksi_out	decimal(10,2)	YES	0.00			
stock_log	1	id_stock_log	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
stock_log	2	created_at	datetime	NO	NULL			
stock_log	3	created_by	int(11)	NO	NULL			
stock_log	4	updated_at	datetime	YES	NULL			
stock_log	5	updated_by	int(11)	YES	NULL			
stock_log	6	product_id	varchar(255)	NO	NULL	MUL		
stock_log	7	cabang_id	varchar(255)	NO	NULL	MUL		
stock_log	8	bulan	varchar(20)	YES	NULL			
stock_log	9	tahun	varchar(15)	YES	NULL			
stock_log	10	gudang_id	int(11)	YES	1	MUL		
stock_log	11	hpp_terakhir	varchar(100)	YES	NULL			
stock_log	12	on_hand	decimal(10,2)	YES	NULL			
stock_log	13	terima	decimal(10,2)	YES	NULL			
stock_log	14	on_order	decimal(10,2)	YES	NULL			
stock_log	15	on_iris_in	decimal(10,2)	YES	NULL			
stock_log	16	on_iris_out	decimal(10,2)	YES	NULL			
stock_log	17	on_demand	decimal(10,2)	YES	NULL			
stock_log	18	keluar	decimal(10,2)	YES	NULL			
stock_log	19	koreksi_in	decimal(10,2)	YES	NULL			
stock_log	20	koreksi_out	decimal(10,2)	YES	NULL			
stock_log	21	log_action_userid	int(11)	YES	NULL			
stock_log	22	log_action_username	varchar(100)	YES	NULL			
stock_log	23	log_action_date	date	YES	NULL			
stock_log	24	log_action_mode	varchar(10)	YES	NULL			
stock_log	25	log_action_from	varchar(255)	YES	NULL			
surat	1	id_surat	int(11) unsigned	NO	NULL	PRI	auto_increment	
surat	2	created_at	datetime	NO	NULL			
surat	3	created_by	int(11)	NO	NULL			
surat	4	updated_at	datetime	YES	NULL			
surat	5	updated_by	int(11)	YES	NULL			
surat	6	no_surat	varchar(255)	NO	NULL			
surat	7	tgl_surat	varchar(255)	NO	NULL			
surat	8	keterangan	varchar(20)	YES	NULL			
surat	9	customer_id	varchar(15)	YES	NULL			
surat	10	keterangan2	tinyint(1)	YES	1			
surat	11	karyawan_id	int(11)	YES	NULL			
terima_item	1	id_terima	int(11) unsigned	NO	NULL	PRI	auto_increment	
terima_item	2	created_at	datetime	NO	NULL			
terima_item	3	created_by	int(11)	NO	NULL			
terima_item	4	updated_at	datetime	YES	NULL			
terima_item	5	updated_by	int(11)	YES	NULL			
terima_item	6	kd_terima	varchar(30)	YES	NULL			
terima_item	7	tgl_terima	date	NO	NULL			
terima_item	8	group_product_id	int(11)	YES	NULL	MUL		
terima_item	9	cabang_id	int(11) unsigned	YES	NULL	MUL		
terima_item	10	pesan_id	bigint(20) unsigned	NO	NULL	MUL		
terima_item	11	vendor_id	int(11) unsigned	YES	NULL	MUL		
terima_item	12	gudang_id	int(11)	YES	NULL	MUL		
terima_item	13	no_reff	varchar(30)	YES	NULL			
terima_item	14	tgl_reff	date	YES	NULL			
terima_item	15	status	tinyint(4)	YES	NULL			
terima_item	16	total_gross	decimal(10,0)	YES	NULL			
terima_item	17	total_ppn	decimal(10,0)	YES	NULL			
terima_item	18	total_diskon	decimal(10,0)	YES	NULL			
terima_item	19	grand_total	decimal(10,0)	YES	NULL			
terima_item	20	tgl_batal	date	YES	NULL			
terima_item	21	keterangan_batal	text	YES	NULL			
terima_item	22	is_ppn	tinyint(4)	YES	0			
terima_item_detail	1	id_terima_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
terima_item_detail	2	created_at	datetime	NO	NULL			
terima_item_detail	3	created_by	int(11)	NO	NULL			
terima_item_detail	4	updated_at	datetime	YES	NULL			
terima_item_detail	5	updated_by	int(11)	YES	NULL			
terima_item_detail	6	terima_id	bigint(20) unsigned	NO	NULL	MUL		
terima_item_detail	7	product_id	bigint(20) unsigned	YES	1	MUL		
terima_item_detail	8	harga_satuan	decimal(10,0)	YES	0			
terima_item_detail	9	qty	decimal(10,0)	YES	0			
terima_item_detail	10	diskon_type	varchar(10)	YES	NULL			
terima_item_detail	11	diskon_value	decimal(10,0)	YES	0			
terima_item_detail	12	netto	decimal(10,0)	YES	0			
terima_item_detail	13	hpp_item_batal	decimal(10,2)	YES	NULL			
terminate	1	id_terminate	int(10) unsigned	NO	NULL	PRI	auto_increment	
terminate	2	created_at	datetime	NO	NULL			
terminate	3	created_by	int(11)	NO	NULL			
terminate	4	updated_at	datetime	YES	NULL			
terminate	5	updated_by	int(11)	YES	NULL			
terminate	6	kd_terminate	varchar(50)	YES	NULL	UNI		
terminate	7	tgl_terminate	varchar(255)	YES	NULL			
terminate	8	pelanggan_id	varchar(255)	YES	NULL	MUL		
terminate	9	keterangan	varchar(255)	YES	NULL			
terminate	10	cabang_id	int(11)	YES	NULL			
terminate_telkom	1	id_terminate	int(10) unsigned	NO	NULL	PRI	auto_increment	
terminate_telkom	2	created_at	datetime	NO	NULL			
terminate_telkom	3	created_by	int(11)	NO	NULL			
terminate_telkom	4	updated_at	datetime	YES	NULL			
terminate_telkom	5	updated_by	int(11)	YES	NULL			
terminate_telkom	6	kd_terminate	varchar(50)	YES	NULL	UNI		
terminate_telkom	7	tgl_terminate	date	YES	NULL	MUL		
terminate_telkom	8	customer_id	bigint(20)	YES	NULL			
terminate_telkom	9	cabang_id	int(11)	YES	NULL			
terminate_telkom	10	keterangan	text	YES	NULL			
terminate_telkom	11	bukti_surat	text	YES	NULL			
terminate_telkom	12	bukti_balasan	text	YES	NULL			
terminate_telkom	13	is_toko_tutup	int(11)	NO	NULL			
tickets	1	ticket_id	int(11)	NO	NULL	PRI	auto_increment	
tickets	2	kd_tiket	varchar(100)	YES	NULL			
tickets	3	tgl_tiket	datetime	YES	NULL			
tickets	4	customer_id	int(11)	NO	NULL			
tickets	5	title	varchar(200)	NO	NULL			
tickets	6	description	text	YES	NULL			
tickets	7	status_id	int(11)	YES	1	MUL		
tickets	8	type_ticket	varchar(100)	YES	NULL			
tickets	9	priority_id	int(11)	YES	2	MUL		
tickets	10	created_at	timestamp	NO	current_timestamp()			
tickets	11	updated_at	timestamp	NO	current_timestamp()		on update current_timestamp()	
tickets	12	created_by	int(11)	YES	NULL			
tickets	13	close_by	int(11)	YES	NULL			
tickets	14	close_date	datetime	YES	NULL			
ticket_assignments	1	assignment_id	int(11)	NO	NULL	PRI	auto_increment	
ticket_assignments	2	ticket_id	int(11)	NO	NULL			
ticket_assignments	3	user_id	int(11)	NO	NULL			
ticket_assignments	4	assigned_at	timestamp	NO	current_timestamp()			
ticket_logs	1	log_id	int(11)	NO	NULL	PRI	auto_increment	
ticket_logs	2	ticket_id	int(11)	NO	NULL			
ticket_logs	3	user_id	int(11)	YES	NULL			
ticket_logs	4	status_id	int(11)	YES	NULL			
ticket_logs	5	log_message	text	NO	NULL			
ticket_logs	6	created_at	timestamp	NO	current_timestamp()			
ticket_priority	1	priority_id	int(11)	NO	NULL	PRI	auto_increment	
ticket_priority	2	priority_name	varchar(50)	NO	NULL			
ticket_status	1	status_id	int(11)	NO	NULL	PRI	auto_increment	
ticket_status	2	status_name	varchar(50)	NO	NULL			
toko	1	kd_toko	varchar(100)	NO	NULL	PRI		
topup	1	id_topup	int(11)	NO	NULL	PRI	auto_increment	
topup	2	tgl_topup	datetime	YES	NULL			
topup	3	no_hp	varchar(30)	YES	NULL			
topup	4	kapasitas	varchar(100)	NO	NULL			
topup	5	harga	varchar(100)	NO	NULL			
topup	6	customer_id	int(11)	YES	NULL			
topup	7	created_by	int(11)	YES	NULL			
topup	8	created_at	datetime	YES	NULL			
topup	9	is_rekap	int(11)	YES	NULL			
topup	10	tgl_beli_berikutnya	date	YES	NULL			
topup	11	toko_id	int(11)	YES	NULL			
topup	12	tgl_batal	datetime	YES	NULL			
topup	13	keterangan_batal	text	YES	NULL			
transaksi_debit	1	id_transaksi	int(11) unsigned	NO	NULL	PRI	auto_increment	
transaksi_debit	2	created_at	datetime	NO	NULL			
transaksi_debit	3	created_by	int(11)	NO	NULL			
transaksi_debit	4	updated_at	datetime	YES	NULL			
transaksi_debit	5	updated_by	int(11)	YES	NULL			
transaksi_debit	6	kd_transaksi	varchar(255)	NO	NULL			
transaksi_debit	7	tgl_transaksi	date	YES	NULL			
transaksi_debit	8	jenis_transaksi	varchar(255)	NO	NULL			
transaksi_debit	9	via_bayar	varchar(255)	YES	NULL			
transaksi_debit	10	coa_id	int(20) unsigned	YES	NULL	MUL		
transaksi_debit	11	vendor_leasing_id	int(11) unsigned	YES	NULL	MUL		
transaksi_debit	12	karyawan_penerima_id	int(11) unsigned	YES	NULL	MUL		
transaksi_debit	13	total	decimal(10,0)	YES	0			
transaksi_debit	14	keterangan	varchar(255)	YES	NULL			
transaksi_debit	15	cabang_id	int(11) unsigned	YES	NULL	MUL		
transaksi_debit	16	keterangan_batal	varchar(255)	YES	NULL			
transaksi_debit	17	tgl_batal	date	YES	NULL			
transaksi_debit	18	tgl_approval	date	YES	NULL			
transaksi_debit	19	status_approval	tinyint(4)	YES	0			
transaksi_debit	20	keterangan_approval	text	YES	NULL			
transaksi_debit	21	karyawan_approval_id	int(11)	YES	NULL	MUL		
transaksi_debit	22	nilai_rekening_koran	decimal(10,0)	YES	NULL			
transaksi_debit	23	is_servis	tinyint(1)	YES	0	MUL		
transaksi_debit	24	nm_customer_alias	varchar(255)	YES	NULL			
transaksi_debit	25	is_debit_note	tinyint(1)	YES	0	MUL		
transaksi_debit	26	no_bukti	varchar(100)	YES	NULL			
transaksi_debit_detail	1	id_transaksi_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
transaksi_debit_detail	2	created_at	datetime	YES	NULL			
transaksi_debit_detail	3	created_by	int(11)	YES	NULL			
transaksi_debit_detail	4	updated_at	datetime	YES	NULL			
transaksi_debit_detail	5	updated_by	int(11)	YES	NULL			
transaksi_debit_detail	6	transaksi_debit_id	bigint(20) unsigned	NO	NULL	MUL		
transaksi_debit_detail	7	invoice_id	bigint(20) unsigned	YES	1	MUL		
transaksi_debit_detail	8	nilai_bayar	decimal(10,0)	YES	0			
transaksi_debit_detail	9	selisih	decimal(10,0)	YES	0			
transaksi_debit_detail	10	coa_id_detail	int(11)	YES	NULL	MUL		
transaksi_debit_detail	11	materai	decimal(10,0)	YES	0			
transaksi_debit_detail	12	keterangan_detail	varchar(255)	YES	NULL			
transaksi_kredit	1	id_transaksi	int(11) unsigned	NO	NULL	PRI	auto_increment	
transaksi_kredit	2	created_at	datetime	YES	NULL			
transaksi_kredit	3	created_by	int(11)	YES	NULL			
transaksi_kredit	4	updated_at	datetime	YES	NULL			
transaksi_kredit	5	updated_by	int(11)	YES	NULL			
transaksi_kredit	6	kd_transaksi	varchar(255)	NO	NULL			
transaksi_kredit	7	tgl_transaksi	date	YES	NULL			
transaksi_kredit	8	jenis_transaksi	varchar(255)	NO	NULL			
transaksi_kredit	9	via_bayar	varchar(255)	YES	NULL			
transaksi_kredit	10	coa_id	int(20) unsigned	YES	NULL	MUL		
transaksi_kredit	11	karyawan_penerima_id	int(11) unsigned	YES	NULL	MUL		
transaksi_kredit	12	total	decimal(10,0)	YES	0			
transaksi_kredit	13	keterangan	varchar(255)	YES	NULL			
transaksi_kredit	14	cabang_id	int(11) unsigned	YES	NULL	MUL		
transaksi_kredit	15	keterangan_batal	varchar(255)	YES	NULL			
transaksi_kredit	16	tgl_batal	date	YES	NULL			
transaksi_kredit	17	tgl_approval	date	YES	NULL			
transaksi_kredit	18	status_approval	tinyint(4)	YES	0			
transaksi_kredit	19	keterangan_approval	text	YES	NULL			
transaksi_kredit	20	karyawan_approval_id	int(11)	YES	NULL	MUL		
transaksi_kredit	21	nilai_rekening_koran	decimal(10,0)	YES	NULL			
transaksi_kredit	22	is_servis	tinyint(4)	YES	NULL			
transaksi_kredit_detail	1	id_transaksi_detail	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
transaksi_kredit_detail	2	created_at	datetime	YES	NULL			
transaksi_kredit_detail	3	created_by	int(11)	YES	NULL			
transaksi_kredit_detail	4	updated_at	datetime	YES	NULL			
transaksi_kredit_detail	5	updated_by	int(11)	YES	NULL			
transaksi_kredit_detail	6	transaksi_kredit_id	bigint(20) unsigned	NO	NULL	MUL		
transaksi_kredit_detail	7	invoice_id	bigint(20) unsigned	YES	1	MUL		
transaksi_kredit_detail	8	nilai_bayar	decimal(10,0)	YES	0			
transaksi_kredit_detail	9	coa_id_detail	int(11)	YES	NULL			
transaksi_kredit_detail	10	type_coa_detail	varchar(10)	YES	NULL			
user	1	id_user	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
user	2	username	varchar(200)	NO	NULL			
user	3	password	text	NO	NULL			
user	4	karyawan_id	int(100) unsigned	NO	NULL	MUL		
user	5	level_id	int(11) unsigned	NO	NULL	MUL		
user	6	created_by	varchar(200)	NO	NULL			
user	7	created_date	datetime	NO	NULL			
users	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
users	2	name	varchar(255)	NO	NULL			
users	3	no_telp	varchar(20)	YES	NULL			
users	4	kd_reseller	varchar(50)	YES	NULL			
users	5	role	enum('admin','technician','finance','sales')	YES	NULL			
users	6	email	varchar(255)	NO	NULL	UNI		
users	7	email_verified_at	timestamp	YES	NULL			
users	8	password	varchar(255)	NO	NULL			
users	9	remember_token	varchar(100)	YES	NULL			
users	10	created_at	timestamp	YES	NULL			
users	11	updated_at	timestamp	YES	NULL			
users	12	is_reseller	tinyint(1)	NO	1			
users	13	reseller_is_active	tinyint(1)	NO	1			
users	14	saldo_reseller	decimal(15,2)	NO	0.00			
users	15	saldo_pending	decimal(15,2)	NO	0.00			
user_cabang	1	id_user_cabang	bigint(20)	NO	NULL	PRI	auto_increment	
user_cabang	2	user_id	int(11)	NO	NULL	MUL		
user_cabang	3	cabang_id	int(11)	NO	NULL	MUL		
user_menu	1	id_user_menu	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
user_menu	2	user_id	bigint(20) unsigned	NO	NULL	MUL		
user_menu	3	menu_id	varchar(50)	NO	NULL	MUL		
user_menu	4	created_by	varchar(200)	YES	NULL			
user_menu	5	created_date	datetime	YES	NULL			
vendor	1	id_vendor	int(11) unsigned	NO	NULL	PRI	auto_increment	
vendor	2	created_at	datetime	YES	NULL			
vendor	3	created_by	int(11)	YES	NULL			
vendor	4	updated_at	datetime	YES	NULL			
vendor	5	updated_by	int(11)	YES	NULL			
vendor	6	kd_vendor	varchar(20)	YES	NULL			
vendor	7	nm_vendor	varchar(255)	NO	NULL			
vendor	8	alamat_vendor	varchar(255)	YES	NULL			
vendor	9	no_telp_vendor	varchar(15)	YES	NULL			
vendor	10	group_vendor_id	int(10) unsigned	YES	NULL	MUL		
vendor	11	status_vendor	tinyint(1)	YES	1			
vendor	12	is_klaim	tinyint(1)	YES	NULL			
vendor	13	cabang_aktif_id	varchar(20)	YES	NULL			
vendor	14	no_rekening	varchar(100)	YES	NULL			
vendor	15	nm_bank	varchar(100)	YES	NULL			
vendor	16	atas_nama	varchar(255)	YES	NULL			
vendor	17	tgl_tempo	tinyint(3)	YES	NULL			
vendor	18	ppn_persen	decimal(10,2)	YES	NULL			
vendor	19	is_vendor_alfa	int(11)	YES	0			
vendor	20	is_aktif_tagihan	int(1)	YES	NULL			
vendor	21	keterangan	varchar(255)	YES	NULL			
vendor_pembayaran	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
vendor_pembayaran	2	vendor_id	int(10) unsigned	NO	NULL	MUL		
vendor_pembayaran	3	bulan	smallint(5) unsigned	NO	NULL			
vendor_pembayaran	4	tahun	smallint(5) unsigned	NO	NULL			
vendor_pembayaran	5	total_nominal	decimal(15,2)	NO	0.00			
vendor_pembayaran	6	ppn	decimal(15,2)	NO	0.00			
vendor_pembayaran	7	total_transfer	decimal(15,2)	NO	0.00			
vendor_pembayaran	8	tgl_bayar	date	YES	NULL			
vendor_pembayaran	9	status	varchar(20)	NO	'belum_bayar'			
vendor_pembayaran	10	keterangan	varchar(255)	YES	NULL			
vendor_pembayaran	11	dibayar_oleh	bigint(20) unsigned	YES	NULL	MUL		
vendor_pembayaran	12	created_at	timestamp	YES	NULL			
vendor_pembayaran	13	updated_at	timestamp	YES	NULL			
vendor_tagihan_item	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
vendor_tagihan_item	2	vendor_id	int(10) unsigned	NO	NULL	MUL		
vendor_tagihan_item	3	nm_item	varchar(150)	YES	NULL			
vendor_tagihan_item	4	paket	varchar(100)	YES	NULL			
vendor_tagihan_item	5	nominal	decimal(15,2)	NO	0.00			
vendor_tagihan_item	6	keterangan	varchar(255)	YES	NULL			
vendor_tagihan_item	7	is_active	tinyint(1)	NO	1			
vendor_tagihan_item	8	urutan	int(11)	NO	0			
vendor_tagihan_item	9	created_at	timestamp	YES	NULL			
vendor_tagihan_item	10	updated_at	timestamp	YES	NULL			
villages	1	id	char(10)	NO	NULL	PRI		
villages	2	district_id	char(7)	NO	NULL	MUL		
villages	3	name	varchar(255)	NO	NULL			
whatsapp_follow_up_logs	1	id	bigint(20) unsigned	NO	NULL	PRI	auto_increment	
whatsapp_follow_up_logs	2	invoice_id	varchar(255)	NO	NULL	MUL		
whatsapp_follow_up_logs	3	pelanggan_nama	varchar(255)	NO	NULL			
whatsapp_follow_up_logs	4	pelanggan_no_layanan	varchar(255)	YES	NULL			
whatsapp_follow_up_logs	5	pelanggan_no_telp	varchar(255)	NO	NULL			
whatsapp_follow_up_logs	6	phone_formatted	varchar(255)	NO	NULL			
whatsapp_follow_up_logs	7	grand_total	decimal(15,2)	NO	NULL			
whatsapp_follow_up_logs	8	message_sent	text	NO	NULL			
whatsapp_follow_up_logs	9	status	enum('success','failed')	NO	'failed'	MUL		
whatsapp_follow_up_logs	10	response_body	text	YES	NULL			
whatsapp_follow_up_logs	11	error_message	varchar(255)	YES	NULL			
whatsapp_follow_up_logs	12	sent_by	bigint(20) unsigned	YES	NULL	MUL		
whatsapp_follow_up_logs	13	created_at	timestamp	YES	NULL	MUL		
whatsapp_follow_up_logs	14	updated_at	timestamp	YES	NULL			
wifi	1	id_wifi	int(11) unsigned	NO	NULL	PRI	auto_increment	
wifi	2	created_at	datetime	NO	NULL			
wifi	3	created_by	int(11)	NO	NULL			
wifi	4	updated_at	datetime	YES	NULL			
wifi	5	updated_by	int(11)	YES	NULL			
wifi	6	ssid_1	varchar(255)	YES	NULL			
wifi	7	ssid_2	varchar(255)	NO	NULL			
wifi	8	pwd	varchar(255)	NO	NULL			
wifi	9	toko_id	varchar(255)	NO	NULL			
wifi	10	keterangan	varchar(15)	YES	''			
wifi	11	is_terpakai	int(10) unsigned	YES	NULL			
wifi2	1	bulan_invoice	int(11)	YES	0			
wifi2	2	no_invoice	varchar(255)	NO	''			
wifi2	3	keterangan	varchar(255)	YES	''			
wifi2	4	nm_customer	varchar(255)	YES	''			
wifi2	5	nilai_bw	int(11)	YES	NULL			
wifi2	6	nilai_perangkat	varchar(255)	YES	NULL			
wifi2	7	tgl_bayar	varchar(255)	YES	NULL			
wifi2	8	alamat	varchar(255)	YES	NULL			
wifi2	9	layanan	varchar(255)	YES	NULL			
wifi2	10	no_layanan	varchar(255)	YES	NULL			
wifi2	11	id	int(11)	NO	NULL	PRI	auto_increment	
wifi3	1	id_wifi3	int(10) unsigned	NO	NULL	PRI	auto_increment	
wifi3	2	created_at	datetime	NO	NULL			
wifi3	3	created_by	int(11)	NO	NULL			
wifi3	4	updated_at	datetime	YES	NULL			
wifi3	5	updated_by	int(11)	YES	NULL			
wifi3	6	no_layanan	varchar(255)	YES	NULL			
wifi3	7	lokasi	varchar(255)	NO	NULL			
wifi3	8	tgl_aktifasi	varchar(255)	NO	NULL			
wifi3	9	nm_pelanggan	varchar(255)	NO	NULL			
wifi3	10	nik	varchar(30)	YES	''			
wifi3	11	no_hp	varbinary(20)	YES	NULL			
wifi3	12	paket	varchar(255)	YES	NULL			
wifi3	13	harga	int(11)	YES	NULL			
wifi3	14	alamat	text	YES	NULL			



