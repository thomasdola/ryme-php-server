<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 3/9/2016
 * Time: 12:44 PM
 */

namespace Eureka\Helpers\Utils;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait UploadFile
{

    public function moveToLocal(UploadedFile $file, $file_name, $path)
    {
        $destinationPath = base_path() . $path;
        $ext = $file->getClientOriginalExtension();
        $fileName = $file_name . '.' . $ext;
        $local_file = $file->move($destinationPath, $fileName);
        return $local_file;
    }

    public function getTrackLength(File $local_track)
    {
        $path_name = $local_track->getPathname();
        $mp3 = new Mp3File($path_name);
        $durTwo = $mp3->getDuration();
        return $durTwo * 1000;
    }

    public function getFullPath(File $local_file, $path)
    {
        $file_name = $local_file->getBasename();
        return $full_path = substr($path, 7) . $file_name;
    }
}