<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE donations MODIFY COLUMN status ENUM('en_attente','confirme','annule') NOT NULL DEFAULT 'en_attente'");
    }
    public function down(): void
    {
        DB::statement("ALTER TABLE donations MODIFY COLUMN status ENUM('confirme','annule') NOT NULL DEFAULT 'confirme'");
    }
};
