<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('book_id')->constrained('books');
            $table->string('status');
            $table->dateTime('date');
            $table->string('payment_id')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('orders');
    }
};
