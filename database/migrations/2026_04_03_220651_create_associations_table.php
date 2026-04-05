<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', [
                'enfants',
                'education',
                'sante',
                'alimentation',
                'environnement',
                'autre'
            ])->default('autre');
            $table->string('region');
            $table->string('logo')->nullable();
            $table->string('document_justif')->nullable();
            $table->enum('status', [
                'en_attente',
                'validee',
                'rejetee'
            ])->default('en_attente');
            $table->text('rejection_reason')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
