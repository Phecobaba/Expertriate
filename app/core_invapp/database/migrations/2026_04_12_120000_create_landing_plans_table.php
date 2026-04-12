<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLandingPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('return_rate', 60);
            $table->string('return_duration', 120);
            $table->decimal('min_amount', 16, 2);
            $table->decimal('max_amount', 16, 2)->nullable();
            $table->string('badge_text', 120)->default('24/7 support');
            $table->longText('features')->nullable();
            $table->string('cta_text', 80)->default('Purchase Plan');
            $table->string('cta_url', 190)->default('/app/register');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('landing_plans')->insert([
            [
                'name' => 'STARTER PLAN',
                'return_rate' => '10%',
                'return_duration' => 'after 24hours',
                'min_amount' => 100,
                'max_amount' => 1999,
                'badge_text' => '24/7 support',
                'features' => json_encode(['Active Support', 'Income Booster', 'Fast Payouts', 'Advanced mining algorithm', '5% referral commission', 'Easy and convenient', 'Instant withdrawal']),
                'cta_text' => 'Purchase Plan',
                'cta_url' => '/app/register',
                'sort_order' => 10,
                'is_recommended' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'AMATEUR PLAN',
                'return_rate' => '30%',
                'return_duration' => 'after 48hours',
                'min_amount' => 2000,
                'max_amount' => 4999,
                'badge_text' => '24/7 support',
                'features' => json_encode(['Active Support', 'Income Booster', 'Fast Payouts', 'Advanced mining algorithm', '5% referral commission', 'Easy and convenient', 'Instant withdrawal']),
                'cta_text' => 'Purchase Plan',
                'cta_url' => '/app/register',
                'sort_order' => 20,
                'is_recommended' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'PROFESSIONAL PLAN',
                'return_rate' => '50%',
                'return_duration' => 'after 96hours',
                'min_amount' => 5000,
                'max_amount' => 9999,
                'badge_text' => '24/7 support',
                'features' => json_encode(['Active Support', 'Income Booster', 'Fast Payouts', 'Advanced mining algorithm', '5% referral commission', 'Easy and convenient', 'Instant withdrawal']),
                'cta_text' => 'Purchase Plan',
                'cta_url' => '/app/register',
                'sort_order' => 30,
                'is_recommended' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'EXPERT PLAN',
                'return_rate' => '70%',
                'return_duration' => 'after 168hours',
                'min_amount' => 10000,
                'max_amount' => null,
                'badge_text' => '24/7 support',
                'features' => json_encode(['Active Support', 'Income Booster', 'Fast Payouts', 'Advanced mining algorithm', '5% referral commission', 'Easy and convenient', 'Instant withdrawal']),
                'cta_text' => 'Purchase Plan',
                'cta_url' => '/app/register',
                'sort_order' => 40,
                'is_recommended' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'LONG-TERM PLAN',
                'return_rate' => '350%',
                'return_duration' => 'after 336hours',
                'min_amount' => 2000,
                'max_amount' => null,
                'badge_text' => '24/7 support',
                'features' => json_encode(['Active Support', 'Income Booster', 'Fast Payouts', 'Advanced mining algorithm', '5% referral commission', 'Easy and convenient', 'Instant withdrawal']),
                'cta_text' => 'Purchase Plan',
                'cta_url' => '/app/register',
                'sort_order' => 50,
                'is_recommended' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_plans');
    }
}

