<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name', 128)->index('idx_name');
            $table->string('description')->nullable();
            $table->enum('discount_type', ['percentage', 'fix-amount'])->index('idx_discount_type');
            $table->integer('amount');
            $table->text('image_url')->nullable();
            $table->integer('code')->default(0);
            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();
            $table->enum('coupon_type', ['private', 'public'])->default('public');
            $table->unsignedInteger('used_count')->default(0);
            $table->softDeletes();
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
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
        });
        Schema::dropIfExists('coupons');
    }
}
