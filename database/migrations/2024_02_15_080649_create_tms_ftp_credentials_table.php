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
            $table->string('name')->comment('Connection name. Example: EmonsInvoices')->unique();
            $table->string('host')->comment('FTP host. The url link to the FTP server. Example: ftp.example.com');
            $table->string('port')->comment('FTP port. Example: 21')->nullable();
            $table->string('username')->comment('FTP username. Example: user');
            $table->string('password')->comment('FTP password. Example: password1234');
            $table->string('path')->comment('FTP path. Example: /path/to/folder')->nullable();
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
