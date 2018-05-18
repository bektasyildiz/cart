<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 17.04.2018
 * Time: 16:05
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('cart'))
            return;
        Schema::create('cart', function (Blueprint $table) {
            $table->integer('id');
            $table->string('identifier')->index();
            $table->string('rowId')->index();
            $table->char('rowStatus', 1)->index();
            $table->string('name');
            $table->double('price', 7, 2);
            $table->integer('qty')->unsigned();
            $table->text('options')->nullable();
            $table->timestamps();
            $table->index(['identifier', 'rowId']);
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
