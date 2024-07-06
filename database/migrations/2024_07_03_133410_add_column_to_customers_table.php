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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('contact_person')->nullable()->after('customer_type');
            $table->string('billing_person')->nullable()->after('contact_person');
            $table->date('agreement_date')->nullable()->after('billing_person');
            $table->date('renew_date')->nullable()->after('agreement_date');
            $table->date('validity_date')->nullable()->after('renew_date');
            $table->decimal('vat',10,2)->default(0)->nullable()->after('validity_date');
            $table->text('attention')->nullable()->after('vat');
            $table->text('attention_details')->nullable()->after('attention');
            $table->string('take_home')->nullable()->after('attention_details');
            $table->string('royal_tea')->nullable()->after('take_home');
            $table->string('ait')->nullable()->after('royal_tea');
            $table->string('received_by_city')->nullable()->after('ait');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('contact_person');
            $table->dropColumn('billing_person');
            $table->dropColumn('agreement_date');
            $table->dropColumn('renew_date');
            $table->dropColumn('validity_date');
            $table->dropColumn('vat');
            $table->dropColumn('attention');
            $table->dropColumn('attention_details');
            $table->dropColumn('take_home');
            $table->dropColumn('royal_tea');
            $table->dropColumn('ait');
            $table->dropColumn('received_by_city');
        });
    }
};
