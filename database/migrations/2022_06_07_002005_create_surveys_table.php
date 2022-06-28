<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('comments');
            $table->string('service_qualification');
            $table->string('filing_qualification');
            $table->timestamps();
        });

        Schema::table('surveys', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropForeign('survey_service_id_foreign');
            $table->dropColumn('service_id');
        });

        Schema::dropIfExists('surveys');
    }
}
