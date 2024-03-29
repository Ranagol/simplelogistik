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
        Schema::create('tms_ftp_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Connection name. Example: EmonsInvoices');
            $table->string('connection_mode')->comment('Example: test or live. Every connection must have a test and a live mode.');
            $table->string('driver')->comment('FTP protocol or driver. Example: ftp or sftp');
            $table->string('host')->comment('FTP host. The url link to the FTP server. Example: ftp.example.com');
            $table->integer('port')->comment('FTP port. Example: 21')->nullable();
            $table->string('username')->comment('FTP username. Example: user')->nullable();
            $table->string('password')->comment('FTP password. Example: password1234')->nullable();
            $table->string('path')->comment('FTP path. Example: /path/to/folder. This is also called root sometimes.')->nullable();
            $table->boolean('passive')->comment('Passive mode. This mode is used to get through firewalls.')->nullable();
            $table->boolean('ssl')->nullable()->comment('enables SSL encryption for the FTP connection. Please note that not all FTP servers support SSL encryption. If you enable this option and the server does not support it, the connection will fail.');
            $table->boolean('throw')->comment('Enables throwing exceptions when an error occurs. This should be true for test, false for live.')->nullable();
            $table->string('comment')->nullable()->comment('Comment for the connection. Example: This connection is used to download invoices from Emons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_ftp_credentials');
    }
};
