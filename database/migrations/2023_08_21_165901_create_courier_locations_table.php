<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up (): void
    {
        Schema::create( 'courier_locations', function ( Blueprint $table ) {
            $table->id();
            $table->float( 'lat', 10, 7 );
            $table->float( 'long', 10, 7 );
            $table->foreignId( 'courier_user_id' )->constrained( 'users' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void
    {
        Schema::dropIfExists( 'courier_locations' );
    }
};
