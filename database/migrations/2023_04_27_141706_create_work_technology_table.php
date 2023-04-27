<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        {
            Schema::create('technology_work', function (Blueprint $table) {
                $table->unsignedBigInteger('work_id');
                $table->foreign('work_id')->references('id')->on('works')->onDelete('CASCADE')->onUpdate('CASCADE');
    
                $table->unsignedBigInteger('technology_id');
                $table->foreign('technology_id')->references('id')->on('technologies')->onDelete('CASCADE')->onUpdate('CASCADE');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technology_work');
    }
};
