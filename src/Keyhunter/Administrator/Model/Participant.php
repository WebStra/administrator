<?php

namespace Keyhunter\Administrator\Model;

use Keyhunter\Administrator\Repository;

class Participant extends Repository
{
    /**
     * @var array
     */
    protected $fillable = ['program_id', 'user_id', 'comment'];

    /**
     * @var string
     */
    protected $table = 'programs_users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function program()
    {
        // deschide bd pls.
        return $this->hasOne(Program::class, 'id', 'program_id');
    }

    /**
     * Retrieve only active languages
     *
     * @param $query
     * @return Language[]
     */
    public function scopeActive($query)
    {
        // nam micro ) toate modelele este, in afara de Page, PageTranslation si Language si User, muta in ~/app/
        $query->where('active', '=', 1);
    }
}