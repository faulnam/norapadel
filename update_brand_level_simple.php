<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Starting brand and level update...\n";

// Check if columns exist
if (!Schema::hasColumn('products', 'brand') || !Schema::hasColumn('products', 'level')) {
    echo "Error: brand or level columns do not exist in products table.\n";
    echo "Please run: php artisan migrate\n";
    exit(1);
}

// Update brand based on product name
echo "Updating brands...\n";
DB::statement("
    UPDATE products
    SET brand = CASE
        WHEN LOWER(name) LIKE '%nox%' THEN 'Nox'
        WHEN LOWER(name) LIKE '%babolat%' THEN 'Babolat'
        WHEN LOWER(name) LIKE '%bullpadel%' THEN 'Bullpadel'
        WHEN LOWER(name) LIKE '%alpha%' THEN 'Alpha'
        WHEN LOWER(name) LIKE '%zephyr%' THEN 'Zephyr'
        WHEN LOWER(name) LIKE '%arronax%' THEN 'Arronax'
        WHEN LOWER(name) LIKE '%skull%' THEN 'Skull'
        WHEN LOWER(name) LIKE '%tactical%' THEN 'Tactical'
        WHEN LOWER(name) LIKE '%starvie%' THEN 'Starvie'
        WHEN LOWER(name) LIKE '%hirostar%' THEN 'Hirostar'
        WHEN LOWER(name) LIKE '%joma%' THEN 'Joma'
        WHEN LOWER(name) LIKE '%wilson%' THEN 'Wilson'
        WHEN LOWER(name) LIKE '%odea%' THEN 'Odea'
        WHEN LOWER(name) LIKE '%edge%' THEN 'Edge'
        WHEN LOWER(name) LIKE '%head%' THEN 'Head'
        WHEN LOWER(name) LIKE '%puma%' THEN 'Puma'
        WHEN LOWER(name) LIKE '%nike%' THEN 'Nike'
        WHEN LOWER(name) LIKE '%adidas%' THEN 'Adidas'
        WHEN LOWER(name) LIKE '%new balance%' THEN 'New Balance'
        WHEN LOWER(name) LIKE '%salomon%' THEN 'Salomon'
        WHEN LOWER(name) LIKE '%brooks%' THEN 'Brooks'
        ELSE NULL
    END
    WHERE brand IS NULL OR brand = ''
");

$brandCount = DB::table('products')->whereNotNull('brand')->count();
echo "Updated $brandCount products with brand data.\n";

// Update level based on product description
echo "Updating levels...\n";
DB::statement("
    UPDATE products
    SET level = CASE
        WHEN LOWER(description) LIKE '%junior%' OR LOWER(description) LIKE '%beginner%' OR LOWER(description) LIKE '%entry%' OR LOWER(name) LIKE '%junior%' OR LOWER(name) LIKE '%girl%' THEN 'beginner'
        WHEN LOWER(description) LIKE '%intermediate%' OR LOWER(description) LIKE '%advanced%' OR LOWER(description) LIKE '%control%' THEN 'intermediate'
        WHEN LOWER(description) LIKE '%pro%' OR LOWER(description) LIKE '%professional%' OR LOWER(description) LIKE '%power%' OR LOWER(description) LIKE '%premier%' OR LOWER(description) LIKE '%expert%' OR LOWER(description) LIKE '%performance%' THEN 'pro'
        ELSE NULL
    END
    WHERE level IS NULL OR level = ''
");

$levelCount = DB::table('products')->whereNotNull('level')->count();
echo "Updated $levelCount products with level data.\n";

echo "\nBrand and level update completed successfully!\n";
echo "Brand breakdown:\n";
$brands = DB::table('products')->select('brand', DB::raw('count(*) as count'))->whereNotNull('brand')->groupBy('brand')->get();
foreach ($brands as $brand) {
    echo "  - {$brand->brand}: {$brand->count} products\n";
}

echo "\nLevel breakdown:\n";
$levels = DB::table('products')->select('level', DB::raw('count(*) as count'))->whereNotNull('level')->groupBy('level')->get();
foreach ($levels as $level) {
    echo "  - {$level->level}: {$level->count} products\n";
}
