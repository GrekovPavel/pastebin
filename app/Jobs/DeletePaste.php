<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Paste;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeletePaste implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Paste $paste;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Paste $paste)
    {
        $this->paste = $paste;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->paste->delete();
    }
}
