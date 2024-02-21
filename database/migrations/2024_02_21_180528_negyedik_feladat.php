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
        DB::unprepared('CREATE TRIGGER negyedikFeladat AFTER INSERT ON baskets
        FOR EACH ROW    
        BEGIN
   
            UPDATE products set quantity = (
                select quantity from products where item_id = NEW.item_id
                ) - 1 
            where item_id = NEW.item_id;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
