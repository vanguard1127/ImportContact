<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_attributes', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collate = 'utf8mb4_unicode_ci';
            $table->engine = "InnoDB";
            $table->id()->startingValue(256);
            $table->timestamps();
            $table->bigInteger('contact_id')->unsigned()->nullable();
            $table->foreign("contact_id")->references('id')->on('contacts')->onDelete('cascade');
            $table->string('key')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('value')->collation('utf8mb4_unicode_ci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_attributes');
    }
}
