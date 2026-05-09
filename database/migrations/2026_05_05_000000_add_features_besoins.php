
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('besoins', function (Blueprint $table) {
            // ✅ Feature 2 : Anonyme ou identifié
            $table->boolean('is_anonymous')->default(false)->after('urgence');

            // ✅ Feature 3 : Pièce jointe
            $table->string('attachment')->nullable()->after('is_anonymous');
        });

        // ✅ Feature 1 : Ajouter 'validee' dans l'enum status
        DB::statement("ALTER TABLE besoins MODIFY COLUMN status ENUM('en_attente','validee','pris_en_charge','resolu') DEFAULT 'en_attente'");
    }

    public function down(): void
    {
        Schema::table('besoins', function (Blueprint $table) {
            $table->dropColumn(['is_anonymous', 'attachment']);
        });
        DB::statement("ALTER TABLE besoins MODIFY COLUMN status ENUM('en_attente','pris_en_charge','resolu') DEFAULT 'en_attente'");
    }
};
