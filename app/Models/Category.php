<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function articleCount()
    {                                                                         /** Category Modelinden */
        return $this->hasMany('App\Models\Article',                    /** Bağlanılacak Model  */
                           'category_id',                           /** Bağlanılacak Sutun  */
                             'id')->whereStatus(1)->count();          /** Bağlanacak Sutun    */

    }
}
