<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('value_cents')->default(0)->after('owner_document');
        });

        $contracts = DB::table('contracts')->get(['id', 'value']);
        foreach ($contracts as $row) {
            $cents = $this->parseDisplayToCents($row->value ?? '');
            DB::table('contracts')->where('id', $row->id)->update(['value_cents' => $cents]);
        }

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('value');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->renameColumn('value_cents', 'value');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('value_legacy')->nullable()->after('owner_document');
        });

        $contracts = DB::table('contracts')->get(['id', 'value']);
        foreach ($contracts as $row) {
            $display = number_format((int) $row->value / 100, 2, ',', '');
            DB::table('contracts')->where('id', $row->id)->update(['value_legacy' => $display]);
        }

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('value');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->renameColumn('value_legacy', 'value');
        });
    }

    private function parseDisplayToCents(string $display): int
    {
        $digits = preg_replace('/\D/', '', $display);
        if ($digits === '') {
            return 0;
        }

        return (int) $digits;
    }
};
