<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('associations', function (Blueprint $table) {
            $table->string('phone_mobile')->nullable()->after('facebook');
            $table->string('phone_fix')->nullable()->after('phone_mobile');
            $table->string('email')->nullable()->after('phone_fix');
            $table->string('doc_rne')->nullable()->after('email');
            $table->string('doc_fiscal')->nullable()->after('doc_rne');
        });
    }

    public function down(): void
    {
        Schema::table('associations', function (Blueprint $table) {
            $table->dropColumn(['phone_mobile','phone_fix','email','doc_rne','doc_fiscal']);
        });
    }
};
