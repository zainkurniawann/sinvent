<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('
            CREATE FUNCTION getKategori(kat VARCHAR(4))
            RETURNS VARCHAR(30)
            DETERMINISTIC
            BEGIN
                IF kat = "M" THEN
                    RETURN "Modal Barang";
                ELSEIF kat = "A" THEN
                    RETURN "Alat";
                ELSEIF kat = "BHP" THEN
                    RETURN "Bahan Habis Pakai";
                ELSEIF kat = "BTHP" THEN
                    RETURN "Bahan Tidak Habis Pakai";
                ELSE
                    RETURN "Unknown";
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getKategori');
    }
};
