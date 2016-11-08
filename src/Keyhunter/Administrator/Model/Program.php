<?php namespace Keyhunter\Administrator\Model;

use Keyhunter\Administrator\Repository;
use Keyhunter\Translatable\HasTranslations;
use Keyhunter\Translatable\Translatable;
use Request;
use File;
use Keyhunter\Administrator\Model\Language as Language;
class Program extends Repository
{
    use HasTranslations;
    protected $translatedAttributes = ['title', 'body'];

    public $translationModel = ProgramTranslation::class;
    public $language = Language::class;

    protected $fillable = ['slug', 'active', 'image'];

    public $timestamps = false;

    public $imgPath  = 'upload/program/';


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
    public function getImageAttribute($value)
    {
        //add full path to image
      if (!empty($value)) {
        return '/'.$value;
      }
    }
    public function setImageAttribute($value)
    {
        //remove file
        if (is_null($value) or $value == "") {

            $image = str_replace('\\', '/', $this->attributes['image']);
            if (File::exists($image)) {
                File::delete($image);
            }

            //clean field
            $this->attributes['image'] = null;

        } else { //add file

            //get name from path
            $imageName = last(explode('/', str_replace('\\', '/', $value)));
            if (Request::hasFile('image')) {
                $extension = Request::file('image')->getClientOriginalExtension();
            }else{
                $extension = File::extension($imageName);
            }
            
            
            $fileName = $this->imgPath.md5(time()).'.'.$extension; // renameing image
            //save in field only image name (without upload directory)
            if (isset($this->attributes['image']) && !empty($this->attributes['image']) && File::exists($this->attributes['image'])) {
                $fileName = $this->imgPath.str_replace('\\', '/', $this->attributes['image']);
            }
            $this->attributes['image'] = $fileName;

            //move image to a new directory
            if (File::exists($imageName)) {
                File::move($imageName, $fileName);
               
            }
        }
    }

    public function delete(){
        if($this->attributes['image']){
            $file = $this->attributes['image'];
            if(File::exists($file)){
                \File::delete($file);
            }
        }
        parent::delete();
    }

    public function getProgramId(){
        return Participant::where('program_id',$this->id)->first();
    }
    public function scopeProgram($query)
    {
        return $query->where('id',$this->getProgramId()->program_id)->first();
    }
}