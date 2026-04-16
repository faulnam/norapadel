-- Fix enum status orders table
-- Jalankan di phpMyAdmin

-- Step 1: Update semua order dengan status 'paid' menjadi 'processing'
UPDATE `orders` SET `status` = 'processing' WHERE `status` = 'paid';

-- Step 2: Ubah enum status (hapus 'paid')
ALTER TABLE `orders` MODIFY COLUMN `status` ENUM(
    'pending_payment',
    'processing',
    'ready_to_ship',
    'shipped',
    'delivered',
    'completed',
    'cancelled'
) NOT NULL DEFAULT 'pending_payment';

-- Verifikasi hasil
SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'orders' AND COLUMN_NAME = 'status';
