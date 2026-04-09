<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('besoins', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('categorie', [
                'alimentation',
                'sante',
                'education',
                'logement',
                'autre'
            ])->default('autre');
            $table->text('description');
            $table->string('region');
            $table->enum('urgence', [
                'normale',
                'urgente',
                'critique'
            ])->default('normale');
            $table->enum('status', [
                'en_attente',
                'pris_en_charge',
                'resolu'
            ])->default('en_attente');
            $table->foreignId('association_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('besoins');
    }
};
