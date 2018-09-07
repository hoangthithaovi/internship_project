<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attached_files', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name_file',150)->default('Not Yes');
            $table->string('attached_file',150);          
            $table->string('describe',255)->default('Not Yes');
            $table->string('folder',150);
            $table->integer('type_file');
            $table->integer('parent_object_id');
            $table->integer('object_id')->unsigned()->index();
            $table->boolean('is_delete')->default(0);
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
        Schema::dropIfExists('attached_files');
    }
}
