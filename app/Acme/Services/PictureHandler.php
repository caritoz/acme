<?php
namespace Acme\Services;
use Acme\Models\Picture;
use Acme\Models\Album;
use Acme\Models\Performedwork;
use Acme\Models\Client;

class PictureHandler
{
    /**
     * @param $file File
     * @param $album Album
     * @param $id object
     * @return string
     */
    public static function mediaStore($file, $album, $id)
    {
        $picture                    = new Picture();
        $picture->caption           = $file->getClientOriginalName();
        $picture->album_id          = $album->id;
        $picture->path              = $album->id;
        $picture->size_picture      = $file->getClientSize();
        $picture->type_picture      = strtolower($file->getClientOriginalExtension());
        $picture->order_picture     = Picture::makeOrder($album->id);

        $picture->save();

        $filename   = $picture->factoryFileName($album, $file, $id);
        $picture->path = $filename;
        $picture->save();

        if( !is_null($id) ):
            switch($album->id):
                case Album::CLIENT:         Client::mediaStore($picture, $id);break;
                case Album::WORKS:          Performedwork::mediaStore($picture, $id);break;
                default:
                    break;
            endswitch;
        endif;

        return $picture;
    }

    /**
    * @param $album_id
    * @param $picture_id
    * @param null $id
    * @return bool
    */
    public static function mediaDestroy($album_id, $picture_id, $id = null)
    {
        if( !$picture_id instanceof Picture)
        {
            $picture    = Picture::find($picture_id);
        }

        if(!$album_id instanceof Album)
        {
            $album  = Album::find($album_id);
        }

        if( !is_null($id) ):
            switch($album->id):// delink with entity
                case Album::CLIENT:         Client::mediaDestroy($picture, $id);break;
                case Album::WORKS:          Performedwork::mediaDestroy($picture, $id);break;
            endswitch;
        endif;

        $success = @unlink(public_path('pictures').'/'.$album->folder.'/'.$picture->path);

        $picture->delete();

        return $success;
    }
}