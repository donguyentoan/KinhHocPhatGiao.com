<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatTableSutras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sutraes', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->longText('content');
            $table->Integer('language_id');
            $table->Integer('athor_id');
            $table->Integer('type_id');
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
        //
    }
}
