<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update brand based on product name
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

        // Update level based on product description
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE products SET brand = NULL, level = NULL");
    }
};
