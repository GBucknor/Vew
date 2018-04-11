<?php

namespace App\Jobs;

use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadProfileImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;
    public $fileId;
    /**
     * Create a new job instance.
     *
     * @param Channel $channel
     * @param $fileId
     */
    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // gets the image from the temporary images folder
        $path = storage_path() . '/uploads/images/' . $this->fileId;
        $filename = $this->fileId . '.png';
        if (Storage::disk('s3images')->put('profile/' . $filename, fopen($path, 'r+'))) {
            File::delete($path);
        }

        $this->channel->avatar_filename = $filename;
        $this->channel->save();
    }
}
