<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\Submodule;
use App\Models\Video;
use App\Models\VideoUploadLogs;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadVideoToCloudinary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $videoPath;
    protected $folderPath;
    protected $id;
    protected $uploadLogId;

    protected bool $isCourse;

    /**
     * Create a new job instance.
     */
    public function __construct($videoPath, $folderPath, $id,$uploadLogId,$isCourse)
    {
        $this->videoPath = $videoPath;
        $this->folderPath = $folderPath;
        $this->id = $id;
        $this->uploadLogId = $uploadLogId;
        $this->isCourse = $isCourse;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $uploadLog = VideoUploadLogs::find($this->uploadLogId);
        try{
            $table = $this->isCourse ? Course::find($this->id) : Submodule::find($this->id);
            $fileUrl = str_replace('\\', '/', $this->videoPath);

            Log::info('Uploading file from local: ' . $fileUrl);

            $videoUploadResponse = Cloudinary::uploadVideo($fileUrl, [
                'folder' => $this->folderPath,
                'resource_type' => 'video',
                'eager' => [
                    'quality' => 'auto'
                ]
            ])->getResponse();
            
            Log::info('Uploading file from local Success: ');
            $video = $table->video_id ? Video::find($table->video_id) : new Video();
            if($video->public_id){
                $delOldVideo = Cloudinary::destroy($video->public_id);
                Log::info("Old Video Delete with Public Id".$video->public_id);
            }
            $video->url = $videoUploadResponse['secure_url'];
            $video->duration = $videoUploadResponse['duration'];
            $video->type = $videoUploadResponse['format'];
            $video->public_id = $videoUploadResponse['public_id'];
            $video->save();

            $table->video_id = $video->id;
            $table->save();

            $uploadLog->update([
                'video_id' => $video->id,
                'video_url' => $video->url,
                'status' => 'success',
            ]);
            $uploadLog->save();
            
            Log::info('Deleting file from local: ' . $fileUrl);
            if(!Storage::disk('local')->exists($fileUrl)){
                Log::info('File Does Not Exists');
            }
            Storage::disk('local')->delete($fileUrl);


        } catch(\Exception $e) {
            $uploadLog->status = 'failed';
            $uploadLog->error_message = $e->getMessage();
            $uploadLog->save();
        }

    }
}
