<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'donateur',
                'association',
                'admin',
                'benevole',
                'internaute'
            ])->default('donateur')->after('email');

            $table->string('phone')->nullable()->after('role');
            $table->string('address')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('address');
            $table->enum('language', ['ar', 'fr', 'en'])
                  ->default('fr')->after('avatar');
            $table->boolean('is_active')->default(true)->after('language');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'phone', 'address',
                'avatar', 'language', 'is_active'
            ]);
        });
    }
};
