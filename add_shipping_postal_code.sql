-- Tambah kolom shipping_postal_code ke tabel orders
ALTER TABLE orders 
ADD COLUMN shipping_postal_code VARCHAR(10) NULL AFTER shipping_address;

-- Set default postal code untuk order yang sudah ada
UPDATE orders 
SET shipping_postal_code = '00000' 
WHERE shipping_postal_code IS NULL;

-- Verifikasi
SELECT id, order_number, shipping_address, shipping_postal_code 
FROM orders 
ORDER BY id DESC 
LIMIT 5;
