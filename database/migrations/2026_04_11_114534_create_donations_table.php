<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->enum('type', [
                'financier',
                'nature',
                'competences'
            ]);
            // Don financier
            $table->decimal('amount', 10, 2)->nullable();
            // Don en nature
            $table->enum('category', [
                'vetements',
                'nourriture',
                'medicaments',
                'scolaire'
            ])->nullable();
            $table->integer('quantity')->nullable();
            $table->string('pickup_address')->nullable();
            // Don de compétences
            $table->string('competence')->nullable();
            $table->string('availability')->nullable();
            $table->text('competence_desc')->nullable();
            // Commun
            $table->text('message')->nullable();
            $table->enum('status', [
                'en_attente',
                'confirme',
                'annule'
            ])->default('confirme');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
