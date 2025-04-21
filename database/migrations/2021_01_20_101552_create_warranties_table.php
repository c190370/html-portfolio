<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranties', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->string('kana');
            $table->integer('construction_id');
            $table->string('tel_fix', 11);
            $table->string('tel_mobile', 11);
            $table->string('zip', 7);
            $table->string('product_name');
            $table->string('product_maker');
            $table->string('product_number');
            $table->date('date_purchase');
            $table->date('date_start');
            $table->date('date_end');
            $table->text('remark');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warranties');
    }
}
