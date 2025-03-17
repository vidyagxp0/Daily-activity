<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('company_weekends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies', 'company_id')->onDelete('cascade');
            $table->json('weekend_days');
            $table->string('year');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('company_weekends');
    }
};
