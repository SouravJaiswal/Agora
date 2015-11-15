<?php

namespace Agora\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model{

	protected $table = 'statuses';

	protected $fillable = ['body'];

	public function user(){
		return $this->belongsTo('Agora\Models\User','user_id');
	}

}