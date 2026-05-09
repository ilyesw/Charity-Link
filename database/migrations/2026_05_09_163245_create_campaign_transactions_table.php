<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaign_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            //$table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->enum('type', ['entree', 'sortie']);
            $table->string('description');
            $table->decimal('montant', 10, 2);
            $table->string('justificatif')->nullable();
            $table->date('date_transaction');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_transactions');
    }
};
