<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs_info', function (Blueprint $table) {
            $table->id('job_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('photographer_id');
            $table->string('type');
            $table->text('description');
            $table->date('date');
            $table->integer('duration');
            $table->decimal('salary', 8, 2);
            $table->string('status')->nullable();
            $table->integer('job_rating')->nullable();
            $table->timestamps();

            // Foreign key references to client_info and photographer_info tables
            $table->foreign('client_id')->references('client_id')->on('client_info')->onDelete('cascade');
            $table->foreign('photographer_id')->references('photographer_id')->on('photographer_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs_info');
    }
}
