<?php
namespace Acme\Facades;
use Acme\Models\Picture;
class PictureControl
{
    /**
     * @param $id
     * @param $entity
     * @param $album
     * @return json
     */
    public static function showEditByAlbum($album)
    {
        $path   = 'pictures/'.$album->folder;

        $pictures        = $album->pictures;

        $files = array();
        if(count($pictures) > 0):
            foreach($pictures as $picture)
            {
//                $picture    = Picture::find($row->id);
                $filename   = $picture->path;

                $success                = new \stdClass;
                $success->name          = $picture->caption;
                $success->size          = (int) $picture->size_picture;
                $success->url           = '/'.$path.'/'.$filename;
                $success->thumbnailUrl  = \URL::to('pictures/' . $picture->id . '/show/smallest' );
                $success->deleteUrl     =  \URL::to('admin/uploads/destroy/' . $filename );
                $success->deleteType    = 'POST';
                $success->fileID        = $filename;

                $files[]                = $success;
            }
        endif;

        $json = json_encode(array('files'=> $files));

        return $json;
    }

    /**
    * @param $id
    * @param $entity
    * @param $album
    * @return json
    */
    public static function showEdit($id, $entity, $album)
    {
        $path   = 'pictures/'.$album->folder;

        $files = array();
        if(count($entity->pictures) > 0):
            foreach($entity->pictures as $pictures)
            {
                $picture    = Picture::find($pictures->id);
                $filename   = $picture->path;

                $success                = new \stdClass;
                $success->name          = \Str::limit($picture->caption,10);
                $success->size          = (int) $picture->size_picture;
                $success->url           = '/'.$path.'/'.$filename;
                $success->thumbnailUrl  = \URL::to('pictures/' . $picture->id . '/show/smallest' );
                $success->deleteUrl     =  \URL::to('admin/uploads/destroy/' . $filename );
                $success->deleteType    = 'POST';
                $success->fileID        = $filename;

                $files[]                = $success;
            }
        endif;

        $json = json_encode(array('files'=> $files));

        return $json;
    }

    /**
    * @param $file
    * @param $filename
    * @param $album
    * @return array
     */
    public static function makeUpload($file, $picture, $album)
    {
        $path   = 'pictures/'.$album->folder;

        $fileTemp = array();
        $fileTemp['name']           = $file->getClientOriginalName(); // (Based on filename)
        $fileTemp['size']           = $file->getClientSize(); // (Based on size)
        $fileTemp['type']           = $file->getClientMimeType(); // (Based on mime type)
        $fileTemp['url']            = '/'.$path.'/'.$picture->path;
        $fileTemp['thumbnailUrl']   = \URL::to('pictures/' . $picture->id . '/show/smallest' );
        $fileTemp['deleteUrl']      =  \URL::to('admin/uploads/destroy/' . $picture->path );
        $fileTemp['deleteType']     = 'POST';
        $fileTemp['fileID']         = $picture->path;

        return $fileTemp;
    }
}