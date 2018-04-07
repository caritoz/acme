<?php
namespace Acme\Models;

class Client extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'company_or_name' => 'required'
	];

    protected $guarded = array();

    public function pictures()
    {
        return $this->belongsToMany('Acme\\Models\\Picture', 'client_picture', 'client_id', 'picture_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('company_or_name', 'LIKE', "%$search%");
    }

    /**
     * @param Picture $picture
     * @param integer $id
     */
    public static function mediaStore($picture, $id)
    {
        $article = Client::find($id);
        $article->pictures()->attach($picture->id);
    }

    /**
     * @param Picture $picture
     * @param integer $id
     */
    public static function mediaDestroy($picture, $id)
    {
        $article = Client::find($id);
        $article->pictures()->detach($picture->id);
    }

    public function pictureFirst()
    {
        if( count($this->pictures) > 0 )
            return $this->pictures->first()->id;
        return null;
    }

    public function urlFriendly()
    {
        $slug = \Str::slug($this->title);
        $url = \URL::to('clients/' . $this->id . '-' . $slug );

        return $url;
    }
}