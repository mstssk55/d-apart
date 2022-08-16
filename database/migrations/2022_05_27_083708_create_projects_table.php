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
            $table->string('client',128)->nullable();
            $table->integer('manager')->nullable();
            $table->string('house_name',128)->nullable();
            $table->date('open_date',128)->nullable();
            $table->date('start_date',128)->nullable();
            $table->date('project_start_date',128)->nullable();
            $table->date('return_debt_date',128)->nullable();

            // 建築プラン-----------------------------------------
            $table->string('plan_kind')->nullable();
            $table->string('structure')->nullable();
            $table->integer('floor')->nullable();
            $table->string('equipment')->nullable();

            // 間取り-----------------------------------------
            $table->integer('floor_total_num')->nullable()->default(0);
            $table->integer('floor_total_area')->nullable()->default(0);

            // 販売価格-----------------------------------------
            $table->integer('price_land')->nullable()->default(0);
            $table->integer('price_prop')->nullable()->default(0);

            // 固定資産税評価額-----------------------------------------
            $table->string('estate_tax_jutaku')->nullable();
            $table->integer('property_tax_area')->nullable()->default(0);
            $table->integer('property_tax_prop')->nullable()->default(0);

            // 登録免許税-----------------------------------------
            $table->integer('display_registration')->nullable()->default(0);
            $table->integer('land_ownership_transfer')->nullable()->default(0);
            $table->integer('prop_ownership_transfer')->nullable()->default(0);
            $table->integer('mortgage_setting_costs')->nullable()->default(0);

            // 不動産取得税-----------------------------------------
            $table->integer('estate_tax_area')->nullable()->default(0);
            $table->integer('estate_tax_prop')->nullable()->default(0);

            // 固定資産税・都市計画税-----------------------------------------
            $table->string('estate_tax_shintiku')->nullable();
            $table->integer('estate_tax_shintiku_year')->nullable();
            $table->integer('property_tax')->nullable();
            $table->integer('city_planning_tax')->nullable();

            // 手数料、保険料-----------------------------------------
            $table->integer('judicial_scrivener_fee')->nullable()->default(0);
            $table->integer('loan_fees')->nullable()->default(0);
            $table->integer('loan_guarantee_fee')->nullable()->default(0);
            $table->integer('brokerage_fee')->nullable()->default(0);

            $table->integer('management_fee')->nullable()->default(0);
            $table->integer('internet_fee')->nullable()->default(0);
            $table->integer('common_electricity')->nullable()->default(0);
            $table->integer('cleaning_fee')->nullable()->default(0);
            $table->integer('transfer_fee')->nullable()->default(0);
            $table->string('housing_insurance_case')->nullable();
            $table->integer('housing_insurance_year')->nullable()->default(0);
            $table->integer('housing_insurance_cost')->nullable()->default(0);
            $table->string('earthquake_insurance_case')->nullable();
            $table->integer('earthquake_insurance_year')->nullable()->default(0);
            $table->integer('earthquake_insurance_cost')->nullable()->default(0);

            // 減価償却--------------------------------------------
            $table->string('building_depreciation_kind')->nullable()->default("定額法");
            $table->integer('building_depreciation_year')->nullable()->default(47);
            $table->integer('building_depreciation_ratio')->nullable()->default(0);
            $table->string('equipment_depreciation_kind')->nullable()->default("定額法");
            $table->integer('equipment_depreciation_year')->nullable()->default(15);
            $table->integer('equipment_depreciation_ratio')->nullable()->default(0);
            $table->float('equipment_ratio')->nullable()->default(30.0);

            // 賃金、借入金内訳-----------------------------------------
            $table->integer('debt')->nullable()->default(0);
            $table->integer('monthly_repayment_amount')->nullable()->default(0);
            $table->integer('own_resources')->nullable()->default(0);
            $table->string('repayment_method')->nullable()->default("元利均等");
            $table->integer('total_expenses')->nullable()->default(0);
            $table->integer('borrowing_period')->nullable()->default(0);
            $table->integer('deferred_period')->nullable()->default(0);
            $table->float('interest_rate')->nullable()->default(0);
            $table->float('ganri_3')->nullable()->default(0);
            $table->float('ganri_5')->nullable()->default(0);
            $table->float('ganri_10')->nullable()->default(0);



            // 事業計画-----------------------------------------
            $table->date('structure_start_date',128)->nullable();
            $table->date('structure_end_date',128)->nullable();
            $table->date('debt_start_date',128)->nullable();
            $table->date('debt_end_date',128)->nullable();
            $table->integer('jigyuo_area_cost')->nullable()->default(0);
            $table->integer('jigyuo_brokerage_fee')->nullable()->default(0);
            $table->integer('jigyuo_syoukai_fee')->nullable()->default(0);
            $table->integer('jigyuo_neteitou')->nullable()->default(0);
            $table->integer('jigyuo_tourokumenkyo')->nullable()->default(0);
            $table->integer('jigyuo_fudousansyutoku')->nullable()->default(0);
            $table->integer('jigyuo_sihousyosi')->nullable()->default(0);
            $table->integer('jigyuo_ginkou_fee')->nullable()->default(0);
            $table->integer('jigyuo_koteisisan')->nullable()->default(0);
            $table->string('jigyuo_risoku')->nullable();
            $table->integer('jigyuo_risoku_fee')->nullable()->default(0);
            $table->integer('jigyuo_tatinoki')->nullable()->default(0);
            $table->integer('jigyuo_kaitai_fee_tubo')->nullable()->default(0);
            $table->integer('jigyuo_kaitai_fee')->nullable()->default(0);
            // $table->string('jigyuo_bikou1')->nullable();
            // $table->string('jigyuo_bikou2')->nullable();
            // $table->string('jigyuo_bikou3')->nullable();
            // $table->integer('jigyuo_bikou1_fee')->nullable()->default(0);
            // $table->integer('jigyuo_bikou2_fee')->nullable()->default(0);
            // $table->integer('jigyuo_bikou3_fee')->nullable()->default(0);
            $table->integer('jigyuo_debt')->nullable()->default(0);

            // $table->integer('other_cost')->nullable();

            $table->integer('jigyuo_kentiku_fee_tubo')->nullable()->default(0);
            $table->integer('jigyuo_kentiku_fee')->nullable()->default(0);
            $table->integer('jigyuo_kui')->nullable()->default(0);
            $table->integer('jigyuo_sekkeikanri')->nullable()->default(0);
            $table->integer('jigyuo_net')->nullable()->default(0);
            $table->integer('jigyuo_jio')->nullable()->default(0);
            $table->integer('jigyuo_gas')->nullable()->default(0);
            $table->integer('jigyuo_ad')->nullable()->default(0);

            // 削除?-----------------------------------------
            $table->integer('household')->nullable();
            $table->float('plan_basement_area')->nullable();
            $table->float('plan_tenant_area')->nullable();
            $table->float('plan_room_area')->nullable();
            $table->float('plan_total_area')->nullable();


            // 固定資産税評価額-----------------------------------------





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
