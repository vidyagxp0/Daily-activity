<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('project_planners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies', 'company_id')->onDelete('cascade');
            $table->string('company_name');
            $table->string('year');
            $table->string('description');
            $table->string('comments')->nullable();
            $table->string('supporting_document')->nullable();
            $table->json('project_details')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('project_planners');
    }
};



