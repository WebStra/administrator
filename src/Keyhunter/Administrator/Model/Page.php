<?php namespace Keyhunter\Administrator\Model;

use Keyhunter\Administrator\Repository;
use Keyhunter\Translatable\HasTranslations;
use Keyhunter\Translatable\Translatable;
use Request;
use Keyhunter\Administrator\Model\Language as Language;
class Page extends Repository implements Translatable
{
    use HasTranslations;

    protected $translatedAttributes = ['title', 'body'];

    protected $fillable = ['slug', 'title', 'body', 'active'];

    protected $table = 'pages';

    public function setSlugAttribute($slug)
    {
        $lng = Language::first();
        if(empty($slug)) $slug = str_slug(strtolower(Request::get($lng->id)['title']));
        else $slug = str_slug(strtolower($slug));
        if($cat = self::where('slug',$slug)->first()){
            $idmax = self::max('id')+1;
            if(isset($this->attributes['id']))
            {
              if ($this->attributes['id'] != $cat->id ){
               $slug = $slug.'_'.++$idmax;
              }
            }
            else
           {
              if (self::where('slug',$slug)->count() > 0)
              $slug = $slug.'_'.++$idmax;
           }
         }
      $this->attributes['slug'] = $slug;
    } 
}
