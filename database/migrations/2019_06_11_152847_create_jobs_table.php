<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 50);
            $table->text('description')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('address')->nullable();
            $table->decimal('lat', 8, 6)->nullable();
            $table->decimal('lon', 9, 6)->nullable();
            $table->point('coordinates')->nullable();
            $table->unsignedTinyInteger('type')->nullable();
            $table->unsignedTinyInteger('contract_length')->nullable();
            $table->unsignedTinyInteger('contract_interval')->nullable();
            $table->unsignedInteger('wage')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
