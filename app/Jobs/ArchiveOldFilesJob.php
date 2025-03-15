<?php

namespace App\Jobs;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ArchiveOldFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $thresholdDate = now()->subYears(5);

        //  $thresholdDate = now()->subYears(5);

        // Find files that are older than 5 years and not archived
        $files = File::where('date_released', '<=', $thresholdDate)
            ->where('is_archived', false)
            ->get();

        foreach ($files as $file) {
            $file->is_archived = true;
            $file->archived_at = now();
            $file->save();
        }

        Log::info("Archived {$files->count()} file(s) older than 5 years.");
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
