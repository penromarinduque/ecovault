<?php

namespace App\Console\Commands;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Console\Command;

class ArchiveOldFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive files older than 5 years';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = now()->subYears(5);

        // Retrieve files older than 5 years
        $files = File::where('created_at', '<=', $thresholdDate)
            ->where('is_archived', false)
            ->get();

        foreach ($files as $file) {
            // Mark the file as archived
            $file->is_archived = true;
            $file->archived_at = now();
            $file->save();
        }

        $this->info("Archived {$files->count()} file(s).");

        return 0;
    }
}
