<?php

use App\Models\Appuser;
use App\Models\Appuserdevice;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Http\UploadedFile;

function userObject($user){
    $data = new \Stdclass();

    $appuser = Appuser::where('id', $user)->first();

    if($appuser) {
        $data->id = $appuser->id;
        $data->name = $appuser->name;
        $data->email = $appuser->email;
        $appuser_device = Appuserdevice::where('appuser_id', $user)->first();
        $data->user_device = isset($appuser_device) ? (object) $appuser_device : new \Stdclass();
    }
}

function uploadFile($file, $foldername)
{
    // Determine the file's MIME type
    $mimeType = $file->getMimeType();

    // Define folder paths based on the file type (image or video)
    if (strstr($mimeType, 'image/')) {
        $fileType = 'image';
    } elseif (strstr($mimeType, 'video/')) {
        $fileType = 'video';
    } else {
        return response()->json(['error' => 'Invalid file type. Only images and videos are allowed.'], 400);
    }

    // Generate a random name for the file with the correct extension
    $randomName = rand(10, 9999999999) . '.' . $file->getClientOriginalExtension();
    $filePath = $foldername . '/' . $fileType . '/' . $randomName;  // Store in separate folders for image and video

    // Get S3 credentials from environment
    $bucket = env('AWS_BUCKET');
    $key = env('AWS_ACCESS_KEY_ID');
    $secret = env('AWS_SECRET_ACCESS_KEY');
    $region = env('AWS_DEFAULT_REGION');

    // Create the S3 client
    $s3 = new S3Client([
        'version' => 'latest',
        'region' => $region,
        'credentials' => [
            'key' => $key,
            'secret' => $secret,
        ],
    ]);

    // Upload the file to S3
    try {
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $filePath,
            'SourceFile' => $file->getPathname(),
            'ContentType' => $mimeType,
            // 'ACL' => 'public-read', // Set file permission, uncomment if needed
        ]);

        // Return the S3 file URL or random name as needed
        return $randomName;
    } catch (AwsException $e) {
        // Output error message if upload fails
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


?>