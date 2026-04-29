-- Fix produk yang has_variants = 1 tapi tidak punya varian aktif
-- Set has_variants = 0 untuk produk yang tidak punya varian

UPDATE products p
LEFT JOIN product_variants pv ON p.id = pv.product_id AND pv.is_active = 1
SET p.has_variants = 0
WHERE p.has_variants = 1 
AND pv.id IS NULL;

-- Cek hasil
SELECT 
    p.id,
    p.name,
    p.has_variants,
    COUNT(pv.id) as variant_count
FROM products p
LEFT JOIN product_variants pv ON p.id = pv.product_id AND pv.is_active = 1
GROUP BY p.id, p.name, p.has_variants
HAVING p.has_variants = 1 AND variant_count = 0;
