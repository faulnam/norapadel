# ✅ Checklist Verifikasi: GoSend & GrabExpress

## 📋 Pre-Testing Checklist

### 1. File Modifications
- [x] `app/Services/BiteshipService.php` - Updated ✅
- [x] `config/biteship.php` - Updated ✅
- [x] `app/Http/Controllers/Customer/ShippingController.php` - Updated ✅
- [x] `resources/views/customer/orders/checkout.blade.php` - Updated ✅

### 2. Configuration
- [ ] `.env` file has `BITESHIP_SANDBOX=true`
- [ ] `.env` file has `BITESHIP_API_KEY` set
- [ ] Config cache cleared
- [ ] Application cache cleared

### 3. Database
- [ ] Products table has `weight` column
- [ ] All products have weight > 0
- [ ] Orders table has courier fields
- [ ] Test user account exists

---

## 🧪 Testing Checklist

### Phase 1: Basic Setup
- [ ] Run `clear-cache.bat` or manual clear cache
- [ ] Server is running (`php artisan serve`)
- [ ] Database is connected
- [ ] No errors in `storage/logs/laravel.log`

### Phase 2: Customer Flow
- [ ] Can login as customer
- [ ] Can view products
- [ ] Can add products to cart
- [ ] Cart shows correct items
- [ ] Can access checkout page

### Phase 3: Checkout Page
- [ ] Checkout page loads without errors
- [ ] Map displays correctly
- [ ] Can click on map to set location
- [ ] "Lokasi Saya" button works
- [ ] Latitude & longitude fields populate
- [ ] Shipping form fields are visible

### Phase 4: Shipping Rates
- [ ] Click location triggers rate calculation
- [ ] Loading indicator shows
- [ ] "Pilih Ekspedisi" section appears
- [ ] Zone info displays (e.g., "Dalam Kota")
- [ ] Weight info displays (e.g., "2 kg")

### Phase 5: Courier Display
- [ ] J&T Express appears
- [ ] AnterAja appears
- [ ] Paxel appears
- [ ] **GoSend appears** ⭐
- [ ] **GrabExpress appears** ⭐

### Phase 6: GoSend Verification
- [ ] GoSend has motorcycle icon (🏍️)
- [ ] GoSend shows "Pilih Layanan" button
- [ ] Can expand GoSend services
- [ ] "Instant" service visible
- [ ] "Same Day" service visible
- [ ] Instant shows "2-4 jam"
- [ ] Same Day shows "Hari ini"
- [ ] Prices display correctly
- [ ] Can select Instant service
- [ ] Can select Same Day service

### Phase 7: GrabExpress Verification
- [ ] GrabExpress has car icon (🚗)
- [ ] GrabExpress shows "Pilih Layanan" button
- [ ] Can expand GrabExpress services
- [ ] "Instant" service visible
- [ ] "Same Day" service visible
- [ ] Instant shows "2-4 jam"
- [ ] Same Day shows "Hari ini"
- [ ] Prices display correctly
- [ ] Can select Instant service
- [ ] Can select Same Day service

### Phase 8: Price Verification (2kg, Dalam Kota)
- [ ] GoSend Instant ≈ Rp 60.000
- [ ] GoSend Same Day ≈ Rp 34.000
- [ ] GrabExpress Instant ≈ Rp 57.000
- [ ] GrabExpress Same Day ≈ Rp 32.000
- [ ] GrabExpress cheaper than GoSend ✅

### Phase 9: Order Summary
- [ ] Selected courier shows in summary
- [ ] Shipping cost updates correctly
- [ ] Total price updates correctly
- [ ] Shipping discount applies (if any)
- [ ] "Buat Pesanan" button enabled

### Phase 10: Order Creation
- [ ] Can submit order
- [ ] Order created successfully
- [ ] Redirected to payment page
- [ ] Order has correct courier_code
- [ ] Order has correct courier_name
- [ ] Order has correct courier_service_name
- [ ] Order has correct shipping_cost

---

## 🔧 Admin Testing Checklist

### Phase 11: Admin Order View
- [ ] Login as admin
- [ ] Can view order list
- [ ] Can open order detail
- [ ] Courier info displays correctly
- [ ] GoSend/GrabExpress name shows
- [ ] Service name shows (Instant/Same Day)

### Phase 12: Request Pickup
- [ ] "Request Pickup" button visible
- [ ] Can click request pickup
- [ ] Loading modal appears
- [ ] Pickup request succeeds
- [ ] Page reloads with courier info

### Phase 13: Courier Info
- [ ] Courier name displays
- [ ] Courier photo displays
- [ ] Courier rating displays
- [ ] Courier phone displays
- [ ] Vehicle type displays
- [ ] Vehicle number displays
- [ ] Waybill ID generated

### Phase 14: Waybill Format
- [ ] GoSend format: `GOSEND-{timestamp}{4digit}`
- [ ] GrabExpress format: `GRAB{12digit}`
- [ ] Waybill is unique
- [ ] Waybill saved to database

---

## 🎯 Zone Testing Checklist

### Test 1: Dalam Kota (≤30 km)
- [ ] Set location within 30 km
- [ ] GoSend appears
- [ ] GrabExpress appears
- [ ] Instant available
- [ ] Same Day available
- [ ] Prices match expected range

### Test 2: Kota Tetangga (30-150 km)
- [ ] Set location 30-150 km away
- [ ] GoSend appears
- [ ] GrabExpress appears
- [ ] Instant available
- [ ] Same Day available
- [ ] Prices higher than dalam kota

### Test 3: Antar Kota (>150 km)
- [ ] Set location >150 km away
- [ ] GoSend does NOT appear ✅
- [ ] GrabExpress does NOT appear ✅
- [ ] Only Regular/Express available

---

## 🐛 Error Testing Checklist

### Test 1: No Location Selected
- [ ] Try checkout without location
- [ ] Error message shows
- [ ] Cannot proceed

### Test 2: Invalid Coordinates
- [ ] Enter invalid lat/lng
- [ ] Error handled gracefully
- [ ] User notified

### Test 3: No Products in Cart
- [ ] Try checkout with empty cart
- [ ] Redirected or error shown

### Test 4: Network Error
- [ ] Simulate network failure
- [ ] Error message shows
- [ ] Can retry

---

## 📊 Performance Checklist

- [ ] Rate calculation < 3 seconds
- [ ] Page load < 2 seconds
- [ ] No console errors
- [ ] No console warnings
- [ ] Map loads smoothly
- [ ] Courier list renders quickly

---

## 🔍 Browser Compatibility

### Desktop
- [ ] Chrome - Works ✅
- [ ] Firefox - Works ✅
- [ ] Edge - Works ✅
- [ ] Safari - Works ✅

### Mobile
- [ ] Chrome Mobile - Works ✅
- [ ] Safari iOS - Works ✅
- [ ] Samsung Internet - Works ✅

---

## 📱 Responsive Testing

- [ ] Desktop (1920x1080) - OK
- [ ] Laptop (1366x768) - OK
- [ ] Tablet (768x1024) - OK
- [ ] Mobile (375x667) - OK
- [ ] Mobile (320x568) - OK

---

## 🎨 UI/UX Checklist

- [ ] Icons display correctly
- [ ] Colors match design
- [ ] Fonts readable
- [ ] Buttons clickable
- [ ] Hover effects work
- [ ] Active states visible
- [ ] Loading states clear
- [ ] Error states helpful

---

## 📝 Documentation Checklist

- [x] README_GOSEND_GRABEXPRESS.md created
- [x] SUMMARY_GOSEND_GRABEXPRESS.md created
- [x] GOSEND_GRABEXPRESS_UPDATE.md created
- [x] TEST_GOSEND_GRABEXPRESS.md created
- [x] VISUAL_FLOW_EKSPEDISI.md created
- [x] QUICK_REFERENCE.md created
- [x] CHECKLIST_VERIFIKASI.md created (this file)
- [x] clear-cache.bat created

---

## ✅ Final Verification

### Code Quality
- [ ] No syntax errors
- [ ] No deprecated functions
- [ ] Follows Laravel conventions
- [ ] Comments are clear
- [ ] Variable names descriptive

### Security
- [ ] No hardcoded credentials
- [ ] CSRF protection enabled
- [ ] Input validation present
- [ ] SQL injection protected
- [ ] XSS protection enabled

### Production Readiness
- [ ] Sandbox mode works
- [ ] Production mode documented
- [ ] Error handling complete
- [ ] Logging implemented
- [ ] Rollback plan exists

---

## 🎉 Sign-off

### Developer
- [ ] All code changes committed
- [ ] All tests passed
- [ ] Documentation complete
- [ ] Ready for review

**Signature:** _________________  
**Date:** _________________

### Reviewer
- [ ] Code reviewed
- [ ] Tests verified
- [ ] Documentation reviewed
- [ ] Approved for deployment

**Signature:** _________________  
**Date:** _________________

---

## 📞 Support Contacts

**Developer:** [Your Name]  
**Email:** [Your Email]  
**Phone:** [Your Phone]

**Emergency:** Check `storage/logs/laravel.log`

---

**Version:** 1.0  
**Last Updated:** 2025  
**Status:** ✅ Ready for Testing
