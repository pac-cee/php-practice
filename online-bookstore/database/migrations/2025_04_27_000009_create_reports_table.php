<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->string('type');
            $table->dateTime('generated_at');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('reports');
    }
};
