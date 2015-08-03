<?php
namespace Module\Content\Model;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;

class Content extends \Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contents';

    public function categories()
    {
        return $this->belongsToMany('Module\Taxonomy\Model\Category', 'contents_categories' ,'content_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Module\Taxonomy\Model\Tag', 'contents_tags' ,'content_id', 'tag_id');
    }

}
