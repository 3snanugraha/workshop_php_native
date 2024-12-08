Revisi Admin
1.	Perbaikan grafik admin: disesuain, misalnya jika ada 1 peserta maka grafiknya langsung dibuat rendah saja
[DONE] Note : tidak ada perubahan untuk grafik, karena grafik ini sifatnya dinamis, Ketika ada data 20 di bulan sebelumnya Maka otomatis pendaftaran di bulan berikutnya cth. 1 data maka akan lebih kecil tingginya -> ini tidak dapat diubah karena sifatnya dinamis, mengkalkulasi semua pendaftaran berdasarkan bulan dan garis X (vertical).
2.	Kalender dihapus
[DONE] Note : -
3.	Pada dashboard admin workshop best seller tersambung query, tergantung seberapa banyak peserta yang mendaftar
[DONE] Note : Dihitung berdasarkan rating dan peserta
4.	Pada laporan data Keeanga ditambahkan total untuk mengetahui penghasilan yang didapat dari keseluruhan workshop 
[DONE] Note: Penambahan Statistik penghasilan Est dan Aktual ( Est untuk semua workshop tanpa peduli potongan dan penghasilan admin), Total Penghasilan (Aktual) -> Penghasilan yang sudah dihitung ( transfer mitra - biaya admin)
5.	Pada aksi fitur keuangan ditambahkan aksi untuk mentransfer ke mitra (membagi hasil pendapatan perworkshop antara admin dan mitra). Total yang ditransfer ke mitra akan masuk otomatis pada tampilan pengeluaran di data keuangan (buatkan laporannya juga untuk melihat rek ap pengeluaran seperti laporan rekap penghasilan) 
[DONE] Note : Penambahan Fitur Transfer (By Mitra), Penambahan Invoice Untuk Mitra -> Terhubung ke halaman mitra -> Transaksi
6.	Menambahkan fitur transaksi yang akan disambungkan dengan aksi tansaksi yang terdapat di data pengeluaran (digunakan sebagai tempat transaksi antara admin dan mitra) 
[DONE] Note : Menu baru mitra -> Transaksi
Ket: penambahan fitur transaksi digunakan untuk transfer/membagi hasil ke mitra yang masuk ke data pengeluaran pada fitur keuangan. Penghasilan didapat dari peserta yang sudah daftar workshop milik mitra (otomatis masuk ke admin dulu), sedangkan pengeluaran yaitu dari admin yang kemudian akan ditransfer ke mitra sebagai bagi hasil antara mitra dan admin. Jadi diperlukan fitur tambahan yaitu fitur transaksi