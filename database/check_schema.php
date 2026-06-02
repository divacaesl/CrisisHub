<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

echo "Campaigns Table Columns:\n";
print_r(Schema::getColumnListing('campaigns'));
echo "\nDonations Table Columns:\n";
print_r(Schema::getColumnListing('donations'));
