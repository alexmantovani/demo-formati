<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_alias')->default('');
            $table->string('alias')->unique();
            $table->string('name');
            $table->enum('type', ['int', 'double', 'bool', 'string','list'])->default('int');
            $table->string('value')->nullable();
            $table->string('rules')->nullable();
            $table->boolean('visible')->default(false);
            $table->string('step')->default(0);
            $table->foreignId('group_title')->default('');
            $table->boolean('favorite')->default(false);
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
        Schema::dropIfExists('formats');
    }
}
