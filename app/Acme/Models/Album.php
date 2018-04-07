<?php
namespace Acme\Models;
//use Acme\Models\Picture;

class Album extends \Eloquent
{
    protected $table = 'albums';

	protected $guarded = array();

	public static $rules = array(
		'caption' => 'required'
	);

    const SLIDER    = 1;
    const WORKS     = 2;
    const CLIENT    = 3;

    public function scopeSearch($query, $search)
    {
        return $query->where('caption', 'LIKE', "%$search%");
    }

    public function scopeFlota($query)
    {
        return $query->whereNotIn('folder', ['slider','clients'])->get();
    }

    public function pictures()
    {
        return $this->hasMany('Acme\\Models\\Picture', 'album_id');
    }

    public function getPath($publicPath = false)
    {
        $pathSlider = '';
        if( $publicPath ) :
            $pathSlider = public_path();
        endif;

        $pathSlider .= '/pictures/'.$this->folder;

        return $pathSlider;
    }

    public function pictureFirst()
    {
        if( count($this->pictures) > 0 )
            return $this->pictures->first()->id;
        return 'default';
    }
}
