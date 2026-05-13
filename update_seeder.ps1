# PowerShell script to update ShopeeProductsSeeder.php with brand and level data

$seederFile = "d:\laragonzo\www\norapadell\database\seeders\ShopeeProductsSeeder.php"
$backupFile = "d:\laragonzo\www\norapadell\database\seeders\ShopeeProductsSeeder.php.backup"

# Create backup
Copy-Item $seederFile $backupFile
Write-Host "Backup created at: $backupFile"

$content = Get-Content $seederFile -Raw

# Function to determine brand based on product name
function Get-Brand {
    param($name)
    $nameLower = $name.ToLower()
    
    if ($nameLower -like "*bullpadel*") { return "Bullpadel" }
    elseif ($nameLower -like "*babolat*") { return "Babolat" }
    elseif ($nameLower -like "*nox*") { return "Nox" }
    elseif ($nameLower -like "*alpha*") { return "Alpha" }
    elseif ($nameLower -like "*zephyr*") { return "Zephyr" }
    elseif ($nameLower -like "*arronax*") { return "Arronax" }
    else { return "null" }
}

# Function to determine level based on product name/description
function Get-Level {
    param($name, $description)
    $textLower = ($name + " " + $description).ToLower()
    
    # Beginner level indicators
    if ($textLower -like "*junior*" -or 
        $textLower -like "*beginner*" -or 
        $textLower -like "*easy to control*" -or 
        $textLower -like "*entry*" -or 
        $textLower -like "*recreational*" -or 
        $textLower -like "*x-zero*") {
        return "beginner"
    }
    
    # Pro level indicators
    if ($textLower -like "*pro*" -or 
        $textLower -like "*expert*" -or 
        $textLower -like "*premier*" -or 
        $textLower -like "*advanced*" -or 
        $textLower -like "*at10*" -or 
        $textLower -like "*vertex 05*" -or 
        $textLower -like "*neuron 02*" -or 
        $textLower -like "*hack 04*" -or 
        $textLower -like "*technical viper*" -or 
        $textLower -like "*counter viper*" -or 
        $textLower -like "*genius attack*" -or 
        $textLower -like "*xplo*" -or 
        $textLower -like "*top level*") {
        return "pro"
    }
    
    # Default to intermediate
    return "intermediate"
}

# Parse and update the file
$lines = $content -split "`n"
$updatedLines = @()
$i = 0
$updatedCount = 0

while ($i -lt $lines.Count) {
    $line = $lines[$i]
    
    # Check if this line contains 'name' key
    if ($line -match "'name'\s*=>\s*'([^']+)'" -or $line -match '"name"\s*=>\s*"([^"]+)"') {
        $productName = $matches[1]
        $brand = Get-Brand $productName
        
        # Look ahead for description
        $description = ""
        $j = $i + 1
        while ($j -lt $lines.Count -and $j -lt $i + 5) {
            if ($lines[$j] -match "'description'\s*=>\s*'([^']+)'" -or $lines[$j] -match '"description"\s*=>\s*"([^"]+)"') {
                $description = $matches[1]
                break
            }
            $j++
        }
        
        $level = Get-Level $productName $description
        
        # Add the current line
        $updatedLines += $line
        
        # Find where to insert brand and level (after category line)
        $k = $i + 1
        $inserted = $false
        while ($k -lt $lines.Count -and $k -lt $i + 15 -and -not $inserted) {
            $updatedLines += $lines[$k]
            
            if ($lines[$k] -match "'category'\s*=>" -or $lines[$k] -match '"category"\s*=>') {
                # Insert brand and level after category
                $indent = "                "
                $brandValue = if ($brand -eq "null") { "null" } else { "'$brand'" }
                $levelValue = if ($level -eq "null") { "null" } else { "'$level'" }
                $updatedLines += "$indent'brand'       => $brandValue,"
                $updatedLines += "$indent'level'       => $levelValue,"
                $inserted = $true
                $updatedCount++
            }
            
            $k++
        }
        
        $i = $k
    } else {
        $updatedLines += $line
        $i++
    }
}

# Write back to file
$updatedContent = $updatedLines -join "`n"
Set-Content $seederFile $updatedContent -NoNewline

Write-Host "✅ Successfully updated $updatedCount products with brand and level data!"
Write-Host "Backup saved at: $backupFile"
