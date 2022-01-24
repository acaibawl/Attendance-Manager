<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_over_next_day');
            $table->date('date');
            $table->time('start');
            $table->time('end');
            $table->timestamps();

        /*
        複数カラムにunique制約を設定する方法
        */
        $table->unique(['user_id', 'date'],    // []内にunique制約を付けたいカラム名を並べる
                       'unique_user_id_date'); // 第2引数はindex名(省略可能)
        /*
            【参考】1つのカラムにunique制約を設定するときは以下のような方法で可能
        */
        // $table->integer('column_name')->unique();      //カラム名を設定するときにunique()を記述する
        // $table->unique('column_name');                 //index名を省略した場合、index名は自動で決まる
        // $table->unique('column_name'  , 'index_name'); // カラムが1つのときは[]はなくても良い
        // $table->unique(['column_name'], 'index_name'); // カラムが1つのときに[]を使っても良い
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
