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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            // we also create Foreign Key here. The purpose being to create a foreign key association between the listings table in our laragig SQL database and the users table. The constrained eloquent method means we are setting this SQL user_id key-colunmn as an SQL constraint on access to other values in the listings table. the onDelete() eloquent method chained on says that, on delete of that user_id, there should be a cascading deletion of all associated listings records/rows for the relevant filled in key-columns on the listings table (i.e. when a user deletes their profile, so too their job listing records are cascadedly deleted.)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string("company");
            $table->string("title");
            $table->string("logo")->nullable(); 
            $table->string("location");
            $table->string("email");
            $table->string("tags");
            $table->longText("description");
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
        Schema::dropIfExists('listings');
    }
};
