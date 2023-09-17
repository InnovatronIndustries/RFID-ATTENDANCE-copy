<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UploadAvatarImagesRequest;
use Storage, ZipArchive;

class UploadAvatarImagesController extends Controller
{
    private $baseView;

    public function __construct()
    {
        $this->baseView = 'cms/file-uploads';
    }

    public function index()
    {
        return view($this->baseView . '/uploadAvatarImages');
    }

    public function store(UploadAvatarImagesRequest $request)
    {
        $zipFile = $request->file('file');
        $originalFileName = $zipFile->getClientOriginalName();

        // Upload the file to S3 while preserving the original file name
        $s3FilePath = Storage::disk('s3')->putFileAs('zip', $zipFile, $originalFileName);
        $s3FileUrl = Storage::disk('s3')->url($s3FilePath);

        // Get the file name from the URL
        $fileName = basename($s3FileUrl);

        // Specify the local storage path
        $localFilePath = storage_path('app/' . $fileName);

        // Download the file from S3 to the local directory
        $fileContents = file_get_contents($s3FileUrl);

        // Store the file locally
        file_put_contents($localFilePath, $fileContents);

        $zip = new ZipArchive;

        if ($zip->open($localFilePath) === true) {

            $extractionPath = storage_path('app/temp');
            $zip->extractTo($extractionPath);
            $zip->close();

            // Upload extracted images to S3
            $extractedFiles = glob($extractionPath . '/*');
            foreach ($extractedFiles as $extractedFile) {
                if (is_file($extractedFile)) {
                    $extractedFileName = basename($extractedFile);
                    $s3DestinationPath = "uploads/avatar/$extractedFileName";
                    Storage::disk('s3')->put(
                        $s3DestinationPath,
                        file_get_contents($extractedFile),
                        $extractedFileName
                    );

                    // Make the file public in S3
                    Storage::disk('s3')->setVisibility($s3DestinationPath, 'public');

                    // unlink($extractionPath . $extractedFile);
                    unlink($extractedFile);
                }
            }

            Storage::disk('s3')->delete('zip/' . $fileName);

        } else {
            return back()->with('failed', 'File has not been opened!');
        }

        // Clean up: Delete the local ZIP file if needed
        unlink($localFilePath);

        return back()->with('success', 'File has been uploaded successfully.');
    }
}
