# PowerShell script to fix duplicate brand and level lines in ShopeeProductsSeeder.php

$seederFile = "d:\laragonzo\www\norapadell\database\seeders\ShopeeProductsSeeder.php"

$content = Get-Content $seederFile -Raw

# Remove duplicate brand lines (keep first occurrence)
$content = $content -replace "('brand'\s*=>\s*'[^']+',)\s*('brand'\s*=>\s*'[^']+',)", "`$1"

# Remove duplicate level lines (keep first occurrence)
$content = $content -replace "('level'\s*=>\s*'[^']+',)\s*('level'\s*=>\s*'[^']+',)", "`$1"

# Also handle null values
$content = $content -replace "('brand'\s*=>\s*null,)\s*('brand'\s*=>\s*null,)", "`$1"
$content = $content -replace "('level'\s*=>\s*null,)\s*('level'\s*=>\s*null,)", "`$1"

Set-Content $seederFile $content -NoNewline

Write-Host "✅ Fixed duplicate brand and level lines!"
