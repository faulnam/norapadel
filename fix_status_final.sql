-- =====================================================
-- FIX FINAL: Update ENUM Status (Hapus 'paid')
-- Copy-paste ke phpMyAdmin dan klik Go
-- =====================================================

ALTER TABLE `orders` MODIFY COLUMN `status` ENUM(
    'pending_payment',
    'processing',
    'ready_to_ship',
    'shipped',
    'delivered',
    'completed',
    'cancelled'
) NOT NULL DEFAULT 'pending_payment';

-- Cek hasil:
SHOW COLUMNS FROM orders LIKE 'status';

-- Harusnya muncul:
-- enum('pending_payment','processing','ready_to_ship','shipped','delivered','completed','cancelled')
