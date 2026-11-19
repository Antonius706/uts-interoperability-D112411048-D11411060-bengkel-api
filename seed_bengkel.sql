-- Jalankan setelah php artisan migrate (database: uts_interoperability)
INSERT INTO customers (name,email,phone,address,city,postal_code,gender,birth_date,occupation,membership,notes,created_at,updated_at) VALUES
('Budi Santoso','budi@mail.com','081234567890','Jl. Merdeka 10','Bandung','40111','L','1995-05-20','Karyawan','silver','Pelanggan tetap',NOW(),NOW()),
('Siti Aminah','siti@mail.com','081298765432','Jl. Dago 25','Bandung','40135','P','1992-08-14','Guru','gold','Servis rutin tiap 3 bulan',NOW(),NOW()),
('Andi Wijaya','andi@mail.com','085611223344','Jl. Cihampelas 7','Bandung','40131','L','1998-01-30','Mahasiswa','reguler',NULL,NOW(),NOW()),
('Dewi Lestari','dewi@mail.com','087755667788','Jl. Buah Batu 88','Bandung','40265','P','1990-11-02','Wiraswasta','silver',NULL,NOW(),NOW()),
('Rudi Hartono','rudi@mail.com','082144556677','Jl. Soekarno Hatta 150','Bandung','40235','L','1987-03-09','Driver online','gold','Kendaraan operasional',NOW(),NOW());

INSERT INTO repairs (customer_id,plate_number,vehicle_brand,vehicle_model,vehicle_year,service_type,complaint,mechanic_name,cost,status,repair_date,created_at,updated_at) VALUES
(1,'D 1234 ABC','Honda','Beat',2020,'Ganti oli','Mesin kasar','Pak Joko',75000,'selesai','2026-11-01',NOW(),NOW()),
(1,'D 1234 ABC','Honda','Beat',2020,'Ganti kampas rem','Rem bunyi','Pak Joko',120000,'selesai','2026-11-10',NOW(),NOW()),
(2,'D 5678 XYZ','Toyota','Avanza',2018,'Servis berkala 40.000 km','Servis rutin','Pak Asep',850000,'dikerjakan','2026-11-15',NOW(),NOW()),
(2,'D 5678 XYZ','Toyota','Avanza',2018,'Spooring balancing','Setir bergetar','Pak Asep',300000,'menunggu','2026-11-18',NOW(),NOW()),
(3,'D 9012 KLM','Yamaha','NMAX',2021,'Ganti ban','Ban aus','Pak Joko',450000,'selesai','2026-11-05',NOW(),NOW()),
(4,'D 3456 PQR','Suzuki','Ertiga',2019,'Tune up','Tarikan berat','Pak Dedi',600000,'diambil','2026-10-28',NOW(),NOW()),
(4,'D 3456 PQR','Suzuki','Ertiga',2019,'Ganti aki','Susah starter','Pak Dedi',950000,'selesai','2026-11-12',NOW(),NOW()),
(5,'D 7788 TUV','Daihatsu','Xenia',2017,'Ganti oli & filter','Servis rutin','Pak Asep',400000,'selesai','2026-11-03',NOW(),NOW()),
(5,'D 7788 TUV','Daihatsu','Xenia',2017,'Perbaikan AC','AC kurang dingin','Pak Dedi',700000,'dikerjakan','2026-11-17',NOW(),NOW()),
(5,'D 7788 TUV','Daihatsu','Xenia',2017,'Ganti kampas kopling','Kopling selip','Pak Dedi',1200000,'menunggu','2026-11-19',NOW(),NOW());
