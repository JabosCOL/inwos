<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('time');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            // $table->unsignedBigInteger('user_id')->nullable()->after('id');
            // $table->foreign('user_id')->references('id')->on('users')

            // También se puede hacer la foreign key usando el metodo foreignId()
            // que hara unsignedBigInteger y dira que sera una foreign y contrained()
            // que indicara a que tabla hace referencia con el nombre de la llave
            // ej: user_id -> users, category_id -> categories. Si esto no coincide podemos
            // indicar la tabla dentro de los parentesis
            // si se van a añadir más metodos a la llave deben ser definidos antes del
            // método constrained()

            $table->foreignId('service_id')->nullable()->after('id')->constrained()
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreignId('user_id')->nullable()->after('id')->constrained()
            ->onUpdate('cascade')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('order_service_id_foreign');
            $table->dropColumn('service_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('order_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('orders');
    }
}
