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
        Schema::create( 'orders', function ( Blueprint $table ) {
            $table->uuid( 'id' )->primary();

            $table->float( 'origin_lat', 10, 7 );
            $table->float( 'origin_long', 10, 7 );
            $table->string( 'origin_address', 255 );
            $table->string( 'provider_name', 255 );
            $table->string( 'provider_phone_number', 20 );

            $table->float( 'destination_lat', 10, 7 );
            $table->float( 'destination_long', 10, 7 );
            $table->string( 'destination_address', 255 );
            $table->string( 'receiver_name', 255 );
            $table->string( 'receiver_phone_number', 20 );

            $table->foreignId( 'corporate_id' )->constrained( 'corporates' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreignId( 'courier_user_id' )->constrained( 'users' )->onUpdate( 'cascade' )->onDelete( 'cascade' );

            $table->tinyInteger( 'status' )->default( \App\Models\Order::STATUS[ 'pending' ] );

            $table->timestamps();
            $table->softDeletes();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void
    {
        Schema::dropIfExists( 'orders' );
    }
};
