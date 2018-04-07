<?php
namespace Acme\Models;

class PerformedworkFeatured extends \Eloquent
{
    protected $table = 'performedwork_featureds';
	protected $fillable = [];

    public static function makeOrder($performedwork_id)
    {
        $featured_order  = 1;
        $order          = PerformedworkFeatured::where('performedwork_id','=', $performedwork_id)->max('featured_order');

        if( !is_null( $order ) )
            $featured_order  = $order;

        return $featured_order;
    }
}