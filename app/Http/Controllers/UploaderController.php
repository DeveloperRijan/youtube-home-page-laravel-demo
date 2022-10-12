<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Storage;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class UploaderController extends Controller
{

  /**
   * Handles the file upload
   *
   * @param Request $request
   *
   * @return JsonResponse
   *
   * @throws UploadMissingFileException
   * @throws UploadFailedException
   */
  public function upload(Request $request) {
    $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

    if ($receiver->isUploaded() === false) {
      throw new UploadMissingFileException();
    }

    $save = $receiver->receive();

    if ($save->isFinished()) {
      return $this->saveFile($save->getFile(), $request);
    }

    $handler = $save->handler();

    return response()->json([
      "done" => $handler->getPercentageDone(),
      'status' => true
    ]);
  }

  /**
   * Saves the file
   *
   * @param UploadedFile $file
   *
   * @return JsonResponse
   */
   protected function saveFile(UploadedFile $file, Request $request) {
     $fileName = $this->createFilename($file);

     // Get file mime type
     $mime_original = $file->getMimeType();
     $mime = str_replace('/', '-', $mime_original);

     $folderDATE = $request->dataDATE;

     $folder  = $folderDATE;
     $filePath = "public/upload/medialibrary/{$folder}/";
     $finalPath = storage_path("app/".$filePath);

     $fileSize = $file->getSize();
     // move the file name
     $file->move($finalPath, $fileName);

     $url_base = 'storage/upload/medialibrary'."/{$folderDATE}/".$fileName;

     Media::create([
        'name' => $fileName,
        'mime' => $mime_original,
        'path' => $filePath,
        'url' => $url_base,
        'size' =>$fileSize
      ]);

     return response()->json([
      'path' => $filePath,
      'name' => $fileName,
      'mime_type' => $mime
     ]);
  }

  /**
   * Create unique filename for uploaded file
   * @param UploadedFile $file
   * @return string
   */
   protected function createFilename(UploadedFile $file) {
     $extension = $file->getClientOriginalExtension();
     $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

     //delete timestamp from file name
     $temp_arr = explode('_', $filename);
     if ( isset($temp_arr[0]) ) unset($temp_arr[0]);
     $filename = implode('_', $temp_arr);

     //here you can manipulate with file name e.g. HASHED
     return $filename.".".$extension;
   }

  /**
   * Delete uploaded file WEB ROUTE
   * @param Request request
   * @return JsonResponse
   */
   public function delete (Request $request){
     $file = $request->filename;

     //delete timestamp from filename
     $temp_arr = explode('_', $file);
     if ( isset($temp_arr[0]) ) unset($temp_arr[0]);
     $file = implode('_', $temp_arr);

     $dir = $request->date;

     $filePath = "public/upload/medialibrary/{$dir}/";
     $finalPath = storage_path("app/".$filePath);

     $fileToDelete = Media::where('name', $file)->first();
     $fileToDelete->delete();

     if ( unlink($finalPath.$file) ){
       return response()->json([
         'status' => 'ok'
       ], 200);
     }
     else{
       return response()->json([
         'status' => 'error'
       ], 403);
     }
   }

}
