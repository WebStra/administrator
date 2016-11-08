<?php namespace Keyhunter\Administrator\Model;

use Keyhunter\Administrator\Repository;
use Request;
use File;
class Settings extends Repository {

    protected $table    = 'options';

    public $timestamps  = false;

    protected $fillable = ['*'];

    static protected $options = null;

  /**
     * Fetch value by key
     *
     * @param $key
     * @param $default
     * @return null
     */
    static public function getOption($key, $default = null)
    {
        if (null === self::$options)
        {
            self::$options = self::listOptions();
        }

		return isset(self::$options[$key]) ? self::$options[$key] : $default;
    }

    /**
     * Fetch all settings
     *
     * @return mixed
     */
    static public function listOptions()
    {
        return (new static)->lists('value', 'key');
    }
    
    public $imgPath  = 'upload/settings/';

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
}