<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolio_transaction', function (Blueprint $table) {
            $table->integer("portfolio_id");
            $table->integer("transaction_id");
            $table->foreign("portfolio_id")->references("id")->on("portfolios")->onDelete("cascade");
            $table->foreign("transaction_id")->references("id")->on("transactions")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_transaction');
    }
};
