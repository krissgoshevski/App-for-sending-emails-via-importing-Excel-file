<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        // Set the default timezone for the duration of this migration
     //   DB::setDefaultConnection('Europe/Skopje');

        Schema::create('sent_emails', function (Blueprint $table) {
            $table->id();
            $table->text('emails')->nullable();
            $table->string('korisnik', 255)->nullable();
            $table->text('adresa_servis')->nullable();
            $table->string('pocetok', 255)->nullable();
            $table->string('kraj', 255)->nullable();
            $table->string('vremetraenje', 255)->nullable();
            $table->string('verzija', 255)->nullable();
            $table->string('naslov', 255)->nullable();
            $table->string('prva_recenica', 255)->nullable();
            $table->string('pricina', 255)->nullable();
            $table->timestamps(); // Timestamps will be in Skopje's timezone
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};
