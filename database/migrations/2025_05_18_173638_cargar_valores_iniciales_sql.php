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
        //
        \Illuminate\Support\Facades\DB::unprepared(
            file_get_contents(storage_path('app/private/sql/init_user.sql'))
        );
        \Illuminate\Support\Facades\DB::unprepared(
            file_get_contents(storage_path('app/private/sql/init_estados.sql'))
        );
        \Illuminate\Support\Facades\DB::unprepared(
            file_get_contents(storage_path('app/private/sql/init_niveles.sql'))
        );
        \Illuminate\Support\Facades\DB::unprepared(
            file_get_contents(storage_path('app/private/sql/init_cargos.sql'))
        );
        \Illuminate\Support\Facades\DB::unprepared(
            file_get_contents(storage_path('app/private/sql/init_permisos.sql'))
        );
        \Illuminate\Support\Facades\DB::unprepared(
            file_get_contents(storage_path('app/private/sql/init_seguridad.sql'))
        );
        \Illuminate\Support\Facades\DB::unprepared(
            file_get_contents(storage_path('app/private/sql/init_socios.sql'))
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
