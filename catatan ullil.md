Edit by : Muhammad Ullil Fahri ( www.mfahri.web.id )

Catatan :

Simadu Berjalan pada Linux Dengan XAMPP PHP 5

=========================================================


SELECT * FROM `alokasi_stok` INNER JOIN lokasi on alokasi_stok.id_gudang = lokasi.id_lokasi WHERE kode_barang = 'TP0001' 

==========

SELECT DISTINCT(id_gudang) ,nama_barang, SUM(jumlah) as jumlahstok , lokasi.nama FROM `alokasi_stok` INNER JOIN lokasi on alokasi_stok.id_gudang = lokasi.id_lokasi WHERE `kode_barang` LIKE 'SG0002' GROUP BY id_gudang


SELECT DISTINCT(id_gudang) ,nama_barang, SUM(jumlah) as jumlahstok , lokasi.nama , kode_barang FROM `alokasi_stok` INNER JOIN lokasi on alokasi_stok.id_gudang = lokasi.id_lokasi GROUP BY alokasi_stok.id_gudang , alokasi_stok.kode_barang ORDER BY `alokasi_stok`.`id_gudang` ASC 

SELECT * FROM `tabel_pembelian` INNER JOIN pembelian_sementara on tabel_pembelian.id_pembelian = pembelian_sementara.id_pembelian ORDER BY `tabel_pembelian`.`tgl_nota` DESC 


SELECT sum(jumlah) as jumlah FROM `tabel_pembelian` INNER JOIN pembelian_sementara on tabel_pembelian.id_pembelian = pembelian_sementara.id_pembelian WHERE kode_barang = 'SA0003' and tgl_nota = '2019-04-23' ORDER BY `tabel_pembelian`.`tgl_nota` ASC 

sa0003

1586525372
1586453274 sisa 12


pembelian dengan akun indv

penjualan dengan kasir
surat jalan indv


untuk retur gunakan admin sinar

retur admin gudag


==========================================

1. Pembelian
Pembelian barang dengan akun distributor indv
contoh barang sa0003 SEMEN ACIAN TR30 @40KG

2. Penjualan 
Oleh Kasir ( Booking Barang)
user kasirsinar 
1586574158

Barang keluar Oleh admingudang 
gudangsinar

        enty pengambilran barang , masukan faktur


3. Retur Barag
retur pada adminsinar
masukan no faktur

alokasi retur gudangsinar