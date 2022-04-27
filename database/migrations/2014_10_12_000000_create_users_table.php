<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            // $table->unsignedBigInteger('user_id')->nullable()->after('id');
            // $table->foreign('user_id')->references('id')->on('users')

            // También se puede hacer la foreign key usando el metodo foreignId()
            // que hara unsignedBigInteger y dira que sera una foreign y contrained()
            // que indicara a que tabla hace referencia con el nombre de la llave
            // ej: user_id -> users, category_id -> categories. Si esto no coincide podemos
            // indicar la tabla dentro de los parentesis
            // si se van a añadir más metodos a la llave deben ser definidos antes del
            // método constrained()

            $table->foreignId('role_id')->nullable()->after('id')->constrained()
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
        Schema::dropIfExists('users');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');
            $table->dropColumn('role_id');
        });
    }
}
