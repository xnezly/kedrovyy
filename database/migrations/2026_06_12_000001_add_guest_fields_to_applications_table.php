<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('guest_name')->nullable()->after('room_id');
            $table->unsignedTinyInteger('guest_age')->nullable()->after('guest_name');
            $table->string('guest_phone', 11)->nullable()->after('guest_age');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_age', 'guest_phone']);
        });
    }
};
