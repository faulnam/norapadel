-- =====================================================
-- FIX ERROR: Data truncated for column 'status'
-- WAJIB DIJALANKAN DI PHPMYADMIN!
-- =====================================================

-- STEP 1: Update ENUM status (PALING PENTING!)
ALTER TABLE `orders` MODIFY COLUMN `status` ENUM(
    'pending_payment',
    'processing',
    'ready_to_ship',
    'shipped',
    'delivered',
    'completed',
    'cancelled'
) NOT NULL DEFAULT 'pending_payment';

-- STEP 2: Tambah kolom kurir driver (jika belum ada)
-- Jika error "Column already exists", skip step ini
ALTER TABLE `orders` 
ADD COLUMN `courier_driver_name` VARCHAR(255) NULL AFTER `waybill_id`,
ADD COLUMN `courier_driver_phone` VARCHAR(255) NULL AFTER `courier_driver_name`,
ADD COLUMN `courier_driver_photo` VARCHAR(255) NULL AFTER `courier_driver_phone`,
ADD COLUMN `courier_driver_rating` DECIMAL(3,2) NULL AFTER `courier_driver_photo`,
ADD COLUMN `courier_driver_vehicle` VARCHAR(255) NULL AFTER `courier_driver_rating`,
ADD COLUMN `courier_driver_vehicle_number` VARCHAR(255) NULL AFTER `courier_driver_vehicle`,
ADD COLUMN `pickup_time` TIMESTAMP NULL AFTER `courier_driver_vehicle_number`;

-- DONE! Sekarang refresh halaman admin dan test lagi.
