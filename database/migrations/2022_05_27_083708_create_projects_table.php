<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name',128);

            // 建築プラン-----------------------------------------
            $table->string('plan_kind')->nullable();
            $table->integer('household')->nullable();
            $table->string('structure')->nullable();
            $table->integer('floor')->nullable();
            $table->string('equipment')->nullable();
            $table->float('plan_basement_area')->nullable();
            $table->float('plan_tenant_area')->nullable();
            $table->float('plan_room_area')->nullable();
            $table->float('plan_total_area')->nullable();

            // 賃金、借入金内訳-----------------------------------------
            $table->integer('debt')->nullable();
            $table->integer('own_resources')->nullable();
            $table->integer('expense')->nullable();
            $table->string('repayment_method')->nullable();
            $table->integer('borrowing_period')->nullable();
            $table->integer('deferred_period')->nullable();
            $table->float('interest_rate')->nullable();
            $table->integer('total_expenses')->nullable();
            $table->integer('monthly_repayment_amount')->nullable();

            // 固定資産税評価額-----------------------------------------
            $table->integer('property_tax_area')->nullable();
            $table->integer('property_tax_prop')->nullable();

            // 不動産取得税-----------------------------------------
            $table->string('estate_tax_jutaku')->nullable();
            $table->string('estate_tax_shintiku')->nullable();
            $table->integer('estate_tax_area')->nullable();
            $table->integer('estate_tax_prop')->nullable();

            // 登録免許税-----------------------------------------
            $table->integer('display_registration')->nullable();
            $table->integer('land_ownership_transfer')->nullable();
            $table->integer('prop_ownership_transfer')->nullable();
            $table->integer('mortgage_setting_costs')->nullable();


            // 手数料、保険料-----------------------------------------
            $table->integer('judicial_scrivener_fee')->nullable();
            $table->integer('loan_fees')->nullable();
            $table->integer('loan_guarantee_fee')->nullable();
            $table->integer('brokerage_fee')->nullable();
            $table->integer('other_cost')->nullable();
            $table->integer('housing_insurance_year')->nullable();
            $table->integer('housing_insurance_cost')->nullable();
            $table->integer('earthquake_insurance_year')->nullable();
            $table->integer('earthquake_insurance_cost')->nullable();

            // 販売価格-----------------------------------------
            $table->integer('price_land')->nullable();
            $table->integer('price_prop')->nullable();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('property_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
