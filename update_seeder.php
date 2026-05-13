<?php

$seederFile = __DIR__ . '/database/seeders/ShopeeProductsSeeder.php';
$content = file_get_contents($seederFile);

// Function to determine brand based on product name
function getBrand($name) {
    $nameLower = strtolower($name);
    
    if (strpos($nameLower, 'bullpadel') !== false) {
        return 'Bullpadel';
    } elseif (strpos($nameLower, 'babolat') !== false) {
        return 'Babolat';
    } elseif (strpos($nameLower, 'nox') !== false) {
        return 'Nox';
    } elseif (strpos($nameLower, 'alpha') !== false) {
        return 'Alpha';
    } elseif (strpos($nameLower, 'zephyr') !== false) {
        return 'Zephyr';
    } elseif (strpos($nameLower, 'arronax') !== false) {
        return 'Arronax';
    } elseif (strpos($nameLower, 'head') !== false && strpos($nameLower, 'zephyr') !== false) {
        return 'Zephyr';
    } elseif (strpos($nameLower, 'skull') !== false) {
        return 'Skull';
    } elseif (strpos($nameLower, 'tactical') !== false) {
        return 'Tactical';
    } elseif (strpos($nameLower, 'starvie') !== false) {
        return 'Starvie';
    } elseif (strpos($nameLower, 'hirostar') !== false) {
        return 'Hirostar';
    } elseif (strpos($nameLower, 'joma') !== false) {
        return 'Joma';
    } elseif (strpos($nameLower, 'wilson') !== false) {
        return 'Wilson';
    } elseif (strpos($nameLower, 'odea') !== false) {
        return 'Odea';
    } elseif (strpos($nameLower, 'edge') !== false) {
        return 'Edge';
    }
    
    return null;
}

// Function to determine level based on product name/description
function getLevel($name, $description) {
    $textLower = strtolower($name . ' ' . $description);
    
    // Beginner level indicators
    if (strpos($textLower, 'junior') !== false ||
        strpos($textLower, 'beginner') !== false ||
        strpos($textLower, 'easy to control') !== false ||
        strpos($textLower, 'entry') !== false ||
        strpos($textLower, 'recreational') !== false ||
        strpos($textLower, 'x-zero') !== false) {
        return 'beginner';
    }
    
    // Pro level indicators
    if (strpos($textLower, 'pro') !== false ||
        strpos($textLower, 'expert') !== false ||
        strpos($textLower, 'premier') !== false ||
        strpos($textLower, 'advanced') !== false ||
        strpos($textLower, 'at10') !== false ||
        strpos($textLower, 'vertex 05') !== false ||
        strpos($textLower, 'neuron 02') !== false ||
        strpos($textLower, 'hack 04') !== false ||
        strpos($textLower, 'technical viper') !== false ||
        strpos($textLower, 'counter viper') !== false ||
        strpos($textLower, 'genius attack') !== false ||
        strpos($textLower, 'xplo') !== false ||
        strpos($textLower, 'top level') !== false) {
        return 'pro';
    }
    
    // Default to intermediate
    return 'intermediate';
}

// Read the seeder file and update each product
$lines = explode("\n", $content);
$updatedLines = [];
$i = 0;

while ($i < count($lines)) {
    $line = $lines[$i];
    
    // Check if this line contains 'name' key
    if (preg_match("/'name'\s*=>\s*'([^']+)'/", $line, $matches)) {
        $productName = $matches[1];
        $brand = getBrand($productName);
        
        // Look ahead for description
        $description = '';
        $j = $i + 1;
        while ($j < count($lines) && $j < $i + 5) {
            if (preg_match("/'description'\s*=>\s*'([^']+)'/", $lines[$j], $descMatches)) {
                $description = $descMatches[1];
                break;
            }
            $j++;
        }
        
        $level = getLevel($productName, $description);
        
        // Add the brand and level after the category line
        $updatedLines[] = $line;
        
        // Find where to insert brand and level (after category line)
        $k = $i + 1;
        while ($k < count($lines) && $k < $i + 10) {
            $updatedLines[] = $lines[$k];
            
            if (preg_match("/'category'\s*=>/", $lines[$k])) {
                // Insert brand and level after category
                $indent = str_repeat(' ', 16);
                $updatedLines[] = $indent . "'brand'       => " . ($brand ? "'$brand'" : 'null') . ",";
                $updatedLines[] = $indent . "'level'       => " . ($level ? "'$level'" : 'null') . ",";
            }
            
            $k++;
        }
        
        $i = $k;
    } else {
        $updatedLines[] = $line;
        $i++;
    }
}

// Write back to file
file_put_contents($seederFile, implode("\n", $updatedLines));

echo "✅ Seeder updated successfully with brand and level data!\n";
