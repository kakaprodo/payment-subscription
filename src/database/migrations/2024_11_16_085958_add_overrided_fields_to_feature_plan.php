<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table((new FeaturePlan())->getTable(), function (Blueprint $table) {
            $table->string('slug_value')
                ->nullable()
                ->comment('this will overwrite the slug_value value in feature');

            $table->boolean('activable')
                ->nullable()
                ->comment('this will overwrite the activable value in feature');

            $table->string('cost')
                ->nullable()
                ->comment('this will overwrite the cost value in feature');

            $table->string('description')->nullable();
            $table->string('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((new FeaturePlan())->getTable(), function (Blueprint $table) {
            $table->dropColumn('slug_value');
            $table->dropColumn('activable');
            $table->dropColumn('cost');
            $table->dropColumn('description');
            $table->dropColumn('name');
        });
    }
};
