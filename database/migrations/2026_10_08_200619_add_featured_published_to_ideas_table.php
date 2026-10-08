<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds admin-managed flags to ideas. Both are nullable/defaulted so the
     * existing mobile app (which never reads these) is unaffected.
     */
    public function up(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            if (! Schema::hasColumn('ideas', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('benefits');
            }
            if (! Schema::hasColumn('ideas', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_published');
            }
            if (! Schema::hasColumn('ideas', 'featured_at')) {
                $table->timestamp('featured_at')->nullable()->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropColumn(['is_published', 'is_featured', 'featured_at']);
        });
    }
};
