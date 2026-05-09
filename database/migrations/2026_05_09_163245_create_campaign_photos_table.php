<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaign_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            //$table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->string('path');
            $table->string('caption')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_photos');
    }
};
