# 🎯 Quick Reference: GoSend & GrabExpress

## ⚡ Quick Commands

```bash
# Clear cache
php artisan config:clear && php artisan cache:clear

# Test URL
http://127.0.0.1:8000/customer/checkout

# Check logs
tail -f storage/logs/laravel.log
```

## 📊 Harga Cepat (2 kg)

### Dalam Kota (≤30 km)
| Ekspedisi | Instant | Same Day |
|-----------|---------|----------|
| GoSend | Rp 60.000 | Rp 34.000 |
| GrabExpress | Rp 57.000 | Rp 32.000 |
| Paxel | Rp 60.000 | Rp 44.000 |

### Kota Tetangga (30-150 km)
| Ekspedisi | Instant | Same Day |
|-----------|---------|----------|
| GoSend | Rp 90.000 | Rp 59.500 |
| GrabExpress | Rp 85.500 | Rp 56.000 |
| Paxel | Rp 90.000 | Rp 77.000 |

## 🔧 File Locations

```
app/Services/BiteshipService.php          ← Logic ekspedisi
config/biteship.php                       ← Config courier
app/Http/Controllers/Customer/
  ShippingController.php                  ← API rates
resources/views/customer/orders/
  checkout.blade.php                      ← UI checkout
```

## 🎨 Icon Codes

```javascript
gosend: 'fa-motorcycle'      // 🏍️
grabexpress: 'fa-car'        // 🚗
jnt: 'fa-truck'              // 🚚
anteraja: 'fa-shipping-fast' // 🚛
paxel: 'fa-bolt'             // ⚡
```

## 📝 Format Resi

```
GoSend:      GOSEND-17763116031234
GrabExpress: GRAB123456789012
J&T:         JT012345678901
AnterAja:    100001234567890
Paxel:       PXL12345678AB
```

## 🗺️ Zona Rules

```
≤30 km    → same_city    → All services ✅
30-150 km → nearby       → All services ✅
150-500km → inter_city   → No Instant/Same Day ❌
>500 km   → inter_island → No Instant/Same Day ❌
```

## 🐛 Debug Checklist

```
□ Clear cache
□ Check .env BITESHIP_SANDBOX=true
□ Check product weight not NULL
□ Check distance < 150 km
□ Check browser console (F12)
□ Check network XHR response
□ Check storage/logs/laravel.log
```

## 💡 Pro Tips

1. **GrabExpress lebih murah** dari GoSend untuk layanan sama
2. **Instant** hanya untuk jarak ≤150 km
3. **Berat minimum** 1 kg untuk semua ekspedisi
4. **Sandbox mode** tidak ada biaya API
5. **Production** butuh saldo min Rp 100.000

## 🚨 Common Issues

### Issue: Ekspedisi tidak muncul
**Fix:** Clear cache + refresh browser

### Issue: Harga tidak sesuai
**Fix:** Cek berat produk di database

### Issue: Error saat pickup
**Fix:** Cek log + pastikan payment verified

### Issue: Resi tidak generate
**Fix:** Cek BiteshipService generateWaybillNumber()

## 📞 Emergency

```bash
# Reset everything
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Check database
SELECT * FROM products WHERE weight IS NULL;
UPDATE products SET weight = 500 WHERE weight IS NULL;

# Check orders
SELECT id, order_number, courier_code, waybill_id 
FROM orders 
WHERE courier_code IN ('gosend', 'grabexpress');
```

## ✅ Success Indicators

- ✅ GoSend muncul dengan icon 🏍️
- ✅ GrabExpress muncul dengan icon 🚗
- ✅ Instant & Same Day tersedia
- ✅ Harga sesuai berat
- ✅ Bisa checkout
- ✅ Resi generate otomatis
- ✅ Kurir data tersimpan

## 📚 Documentation Files

```
README_GOSEND_GRABEXPRESS.md      ← Start here
SUMMARY_GOSEND_GRABEXPRESS.md     ← Complete summary
GOSEND_GRABEXPRESS_UPDATE.md      ← Technical details
TEST_GOSEND_GRABEXPRESS.md        ← Testing guide
VISUAL_FLOW_EKSPEDISI.md          ← Visual diagrams
QUICK_REFERENCE.md                ← This file
```

## 🎯 Testing Flow

```
1. clear-cache.bat
2. Login customer
3. Add to cart
4. Checkout
5. Pick location
6. See GoSend & GrabExpress ✅
7. Select & pay
8. Admin pickup
9. Done! 🎉
```

---

**Last Updated:** 2025  
**Version:** 1.0  
**Status:** ✅ Ready
