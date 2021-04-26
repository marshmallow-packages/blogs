<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Marshmallow\HelperFunctions\Traits\MigrationHelper;

class CreateBlogsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_tag_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('intro')->nullable();
            $table->text('content')->nullable();
            $table->text('overview_image')->nullable();
            $table->text('detail_image')->nullable();
            $table->datetime('publish_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_tags');
    }
}
