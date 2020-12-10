<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collate = 'utf8mb4_unicode_ci';
            $table->engine = "InnoDB";
            $table->id()->startingValue(256);
            $table->timestamps();
            $table->integer('team_id');
            $table->string('name')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('phone')->collation('utf8mb4_unicode_ci');
            $table->string('email')->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('sticky_phone_number_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
