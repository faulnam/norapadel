-- Cek struktur tabel orders
DESCRIBE orders;

-- Cek apakah ada kolom shipping_postal_code
SHOW COLUMNS FROM orders LIKE 'shipping%';
