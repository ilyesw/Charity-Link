<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE donations MODIFY COLUMN category ENUM('vetements','nourriture','medicaments','scolaire','autre') NULL");
    }
    public function down(): void
    {
        DB::statement("ALTER TABLE donations MODIFY COLUMN category ENUM('vetements','nourriture','medicaments','scolaire') NULL");
    }
};
