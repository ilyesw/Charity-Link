<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('nature')->nullable()->after('title');
            $table->string('affiche')->nullable()->after('nature');
            $table->string('objectif_description')->nullable()->after('goal_amount');
            $table->date('date_debut')->nullable()->after('objectif_description');
            $table->text('compte_rendu')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['nature', 'affiche', 'objectif_description', 'date_debut', 'compte_rendu']);
        });
    }
};
