<?php
$files = [
    'resources/views/pages/shop.blade.php',
    'resources/views/pages/racket.blade.php',
    'resources/views/pages/shoes.blade.php',
    'resources/views/pages/apparel.blade.php',
    'resources/views/pages/new-arrivals.blade.php',
    'resources/views/pages/contact.blade.php',
    'resources/views/pages/policy.blade.php',
    'resources/views/pages/help-center.blade.php',
    'resources/views/pages/guarantee.blade.php',
    'resources/views/pages/return-refund.blade.php',
    'resources/views/pages/product-detail.blade.php',
    'resources/views/customer/wishlist/index.blade.php',
    'resources/views/customer/cart/index.blade.php',
    'resources/views/customer/orders/checkout.blade.php',
];

foreach ($files as $f) {
    if (!file_exists($f)) {
        echo "SKIP: $f\n";
        continue;
    }
    $content = file_get_contents($f);
    // Remove from <div class="bg-white text-black antialiased"> through </header> and <main class="bg-white"> (<br> optional)
    $pattern = '/<div class="bg-white text-black antialiased">\s*<style>[^<]*<\/style>\s*<header[^>]*>.*?<\/header>\s*<main class="bg-white">\s*(<br>\s*)?/s';
    $replacement = "<div class=\"bg-white text-black antialiased\">\n    @include('components.luxury-navbar')\n    <main class=\"bg-white pt-24 md:pt-20\">\n";
    $new = preg_replace($pattern, $replacement, $content);
    if ($new !== $content) {
        file_put_contents($f, $new);
        echo "OK: $f\n";
    } else {
        // Try alternate pattern for files without <style> block
        $pattern2 = '/<div class="bg-white text-black antialiased">\s*<header[^>]*>.*?<\/header>\s*<main class="bg-white">\s*(<br>\s*)?/s';
        $new2 = preg_replace($pattern2, $replacement, $content);
        if ($new2 !== $content) {
            file_put_contents($f, $new2);
            echo "OK (alt): $f\n";
        } else {
            echo "NO MATCH: $f\n";
        }
    }
}
echo "Done.\n";
