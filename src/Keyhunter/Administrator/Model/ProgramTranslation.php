<?php namespace Keyhunter\Administrator\Model;

use Illuminate\Database\Eloquent\Model;

class ProgramTranslation extends Model {

    public $timestamps = false;

    protected $fillable = ['title', 'body'];

}
