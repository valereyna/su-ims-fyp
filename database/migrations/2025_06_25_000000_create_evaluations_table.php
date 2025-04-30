<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('advisor_id')->nullable();

            // University evaluation scores
            $table->integer('job_knowledge')->nullable();
            $table->integer('analysis')->nullable();
            $table->integer('report_presentation')->nullable();

            // Company evaluation scores
            $table->integer('enthusiasm_attitude')->nullable();
            $table->integer('work_quality')->nullable();
            $table->integer('timeliness')->nullable();
            $table->integer('company_job_knowledge')->nullable();
            $table->integer('decision_making')->nullable();
            $table->integer('reporting_communication')->nullable();

            // Calculated weighted scores
            $table->float('university_weighted_score')->nullable();
            $table->float('company_weighted_score')->nullable();
            $table->float('total_score')->nullable();

            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('advisor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};
