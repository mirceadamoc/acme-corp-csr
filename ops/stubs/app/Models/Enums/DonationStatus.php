<?php
namespace App\Models\Enums;
enum DonationStatus: string { case Pending='pending'; case Confirmed='confirmed'; case Failed='failed'; }
