<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('association_id')->constrained()->onDelete('cascade');
            $table->foreignId('benevole_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->string('competence_requise');
            $table->date('deadline')->nullable();
            $table->enum('status', [
                'ouverte',
                'en_cours',
                'validee',
                'annulee'
            ])->default('ouverte');
            $table->text('feedback')->nullable();
            $table->text('compte_rendu')->nullable();
            $table->integer('note_association')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
