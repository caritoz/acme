<?php
namespace Acme\Controllers\Backoffice;
use Acme\Facades\PictureControl;
use Acme\Models\Picture;
use Acme\Models\Album;

use Acme\Services\PictureHandler;
use Intervention\Image\ImageManagerStatic as Image;

class UploadController extends \BaseController
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store()
    {
        $files_uploads = array();

        if(\Input::hasFile('file'))
        {
            $id     = \Input::get('id');
            $album  = Album::findOrFail(\Input::get('album'));

            $path   = 'pictures/'.$album->folder;

            $file   = \Input::file('file');
//            foreach(\Input::file('file') as $file)
            {
                $rules = array(
                    'file' => 'required|mimes:png,gif,jpeg|max:20000'
                );

                $validator = \Validator::make(array('file'=> $file), $rules);

                if($validator->passes())
                {

                    $picture    = PictureHandler::mediaStore($file, $album, $id);
                    $fileTemp   = PictureControl::makeUpload($file, $picture, $album);

                    //$uploads = $file->move(public_path('uploads'), $fileTemp['name']);
                    $uploads = $file->move(public_path($path), $picture->path);

                    if($uploads)
                        $files_uploads[] = $fileTemp;
                }
                else
                {
                    //Does not pass validation
                    $errors = $validator->errors();
                }
            }

            return \Response::json(['success' => 'OK', 'files' => $files_uploads]);
        }

        return \Response::json(array('success' => 'ERR'));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string  $id (filename)
	 * @return Response
	 */
	public function destroy($id)
	{
        $album  = $picture = $model = null;
        $path   = public_path('pictures');

        $parts  = explode('_', $id);

        if( isset($parts[0]) ):
            $album_id  = $parts[0];
//            $album     = \DB::table('albums')->where('folder', $album_id)->first();
            $album     = Album::where('folder', '=', $album_id)->first();
        endif;

        if( isset($parts[1]) ):
            $picture = pathinfo($parts[1]);
            $picture = $picture['filename'];
        endif;

        if( isset($parts[2]) ):
            $model  = pathinfo($parts[2]);
            $model  = $model['filename'];
        endif;

        $success = PictureHandler::mediaDestroy($album->id, $picture, $model);

//        $success = unlink($path.'/'.$album.'/'.$id);

        return \Response::json(array('files'=> array($success)), 200);
	}

    public function storeAlbum()
    {
        $files_uploads = array();

        if(\Input::hasFile('file'))
        {
            $album  = Album::findOrFail(\Input::get('album'));

            $path   = 'pictures/'.$album->folder;

            $file   = \Input::file('file');

            $rules = array(
                'file' => 'required|mimes:png,gif,jpeg|max:20000'
            );

            $validator = \Validator::make(array('file'=> $file), $rules);

            if($validator->passes())
            {

                $picture    = PictureHandler::mediaStore($file, $album, null);
                $fileTemp   = PictureControl::makeUpload($file, $picture, $album);

                //$uploads = $file->move(public_path('uploads'), $fileTemp['name']);
                $uploads = $file->move(public_path($path), $picture->path);

                if($uploads)
                    $files_uploads[] = $fileTemp;
            }
            else
            {
                //Does not pass validation
                $errors = $validator->errors();
            }


            return \Response::json(['success' => 'OK', 'files' => $files_uploads]);
        }

        return \Response::json(array('success' => 'ERR'));
    }
}
