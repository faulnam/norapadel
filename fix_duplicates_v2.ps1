# PowerShell script to fix duplicate brand and level lines in ShopeeProductsSeeder.php

$seederFile = "d:\laragonzo\www\norapadell\database\seeders\ShopeeProductsSeeder.php"

$lines = Get-Content $seederFile
$cleanedLines = @()
$i = 0

while ($i -lt $lines.Count) {
    $line = $lines[$i]
    
    # Check if this is a brand line
    if ($line -match "'brand'\s*=>\s*") {
        # Add this line
        $cleanedLines += $line
        $i++
        
        # Skip any subsequent brand lines
        while ($i -lt $lines.Count -and $lines[$i] -match "'brand'\s*=>\s*") {
            $i++
        }
    }
    # Check if this is a level line
    elseif ($line -match "'level'\s*=>\s*") {
        # Add this line
        $cleanedLines += $line
        $i++
        
        # Skip any subsequent level lines
        while ($i -lt $lines.Count -and $lines[$i] -match "'level'\s*=>\s*") {
            $i++
        }
    }
    else {
        $cleanedLines += $line
        $i++
    }
}

Set-Content $seederFile $cleanedLines -NoNewline

Write-Host "✅ Fixed duplicate brand and level lines!"
