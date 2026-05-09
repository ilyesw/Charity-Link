<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->unsignedBigInteger('campaign_id')->nullable()->after('association_id');
           // $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
            $table->dropColumn('campaign_id');
        });
    }
};
