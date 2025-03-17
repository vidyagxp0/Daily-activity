<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('company_id');
            $table->string('name')->unique();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('companies');
    }
};
