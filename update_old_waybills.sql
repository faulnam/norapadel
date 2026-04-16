-- Update nomor resi lama (PTH format) ke format ekspedisi baru
-- Jalankan di phpMyAdmin atau MySQL client

-- Update untuk J&T Express (jnt)
UPDATE orders 
SET waybill_id = CONCAT('JT', LPAD(FLOOR(RAND() * 1000000000000), 12, '0'))
WHERE courier_code = 'jnt' 
AND (waybill_id LIKE 'PTH-%' OR waybill_id IS NULL OR waybill_id = '');

-- Update untuk AnterAja (anteraja)
UPDATE orders 
SET waybill_id = CONCAT('10000', LPAD(FLOOR(RAND() * 10000000000), 10, '0'))
WHERE courier_code = 'anteraja' 
AND (waybill_id LIKE 'PTH-%' OR waybill_id IS NULL OR waybill_id = '');

-- Update untuk Paxel (paxel)
UPDATE orders 
SET waybill_id = CONCAT('PXL', LPAD(FLOOR(RAND() * 100000000), 8, '0'), 
                        CHAR(65 + FLOOR(RAND() * 26)), 
                        CHAR(65 + FLOOR(RAND() * 26)))
WHERE courier_code = 'paxel' 
AND (waybill_id LIKE 'PTH-%' OR waybill_id IS NULL OR waybill_id = '');

-- Verifikasi hasil
SELECT order_number, courier_code, courier_name, waybill_id 
FROM orders 
WHERE waybill_id IS NOT NULL 
ORDER BY id DESC;
