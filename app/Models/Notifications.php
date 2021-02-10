<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model {
    /**
      * The database table used by the model.
      *
      * @var string
      */
    //here i should call the external database table
    protected $connection = 'db_portal';
}