-- Cek biteship_order_id dari order #9
SELECT id, order_number, biteship_order_id, waybill_id, courier_code, courier_name, status
FROM orders 
WHERE id = 9;

-- Cek semua order yang punya biteship_order_id
SELECT id, order_number, biteship_order_id, waybill_id, courier_code, status
FROM orders 
WHERE biteship_order_id IS NOT NULL
ORDER BY id DESC;
