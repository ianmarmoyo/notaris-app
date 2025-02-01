<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Storage;

/**
 *  Storing file support
 */

class FileStorage
{
  /**
   *  Storing file and merge if there is already stored file with same name
   * 
   *  @param \File $file
   *  @param string $path
   *  @param (string $filename || null)
   * 
   *  @return \Illuminate\Support\Facades\Storage
   */
  public function touch($file, $path, $filename = null)
  {
    $ext = $file->getClientOriginalExtension();

    $filename = $filename ? $filename : $file->getClientOriginalName();
    return Storage::putFileAs($path, $file, "$filename.$ext");
  }

  /** 
   *  Remove specified file from the given file path. 
   *  if $skipOnNull is true then return true if file doesn't exist in filesystem. 
   * 
   *  @param string $path
   *  @param (bool $skipOnNull || null)  
   * 
   *  @return \Illuminate\Support\Facades\Storage
   */
  public function prune($path, $skipOnNull = null)
  {
    $prune = true;
    if (Storage::exists($path)) {
      $prune = Storage::delete($path);
    }

    return $skipOnNull ? true : $prune;
  }

  /**
   *  Remove specfied directory from the given path.
   * 
   *  @param string $directory
   * 
   *  @return \Illuminate\Support\Facades\Storage
   */
  public function flush($directory)
  {
    return Storage::deleteDirectory($directory);
  }
}
