<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->enum('type_don', ['argent', 'nature'])->default('argent')->after('campaign_id');
            $table->string('description_nature')->nullable()->after('type_don');
            $table->integer('quantite')->nullable()->after('description_nature');
            $table->decimal('valeur_estimee', 10, 2)->nullable()->after('quantite');
            $table->string('justificatif')->nullable()->after('valeur_estimee');
            $table->boolean('is_anonymous')->default(true)->after('justificatif');
            $table->string('display_name')->nullable()->after('is_anonymous');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn([
                'type_don', 'description_nature', 'quantite',
                'valeur_estimee', 'justificatif', 'is_anonymous', 'display_name'
            ]);
        });
    }
};
