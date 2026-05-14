<?php

use App\Enums\ApplicationStatusEnum;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Room::class)->constrained();
            $table->unsignedTinyInteger('number_of_guests');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->text('comment')->nullable();
            $table->string('status')->default(ApplicationStatusEnum::PENDING);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
