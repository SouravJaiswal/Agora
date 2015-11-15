<?php

namespace Agora\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password','first_name','last_name','location','username'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getName()
    {
        if($this->first_name && $this->last_name){
            return "{$this->first_name} {$this->last_name}";
        }

        if($this->first_name){
            return $this->first_name;
        }

        return null;
    }

    public function getNameOrUsername(){
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUserName(){
        return $this->first_name ?: $this->username;
    }

    public function getAvatar(){
        return 'http://www.gravatar.com/avatar/{{md5($this->email)}}?d=mm&s=40';
    }

    public function statuses(){
        return $this->hasMany('Agora\Models\Status','user_id');
    }

    public function likes(){
        return $this->hasMany('Agora\Models\Like','user_id');
    }

    public function friendsOfMine(){
        return $this->belongsToMany('Agora\Models\User','friends','user_id','friend_id');
    }

    public function friendsOf(){
        return $this->belongsToMany('Agora\Models\User','friends','friend_id','user_id');
    }

    public function friends(){
        return $this->friendsOfMine()->wherePivot('accepted',true)
                    ->get()->merge($this->friendsOf()->wherePivot('accepted',true)->get());
    }

    public function friendsRequest(){
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }

    public function friendRequestsPending(){
        return $this->friendsOf()->wherePivot('accepted',false)->get();
    }

    public function hasFriendRequestPending(User $user){
        return (bool) $this->friendRequestsPending()->where('id',$user->id)->count();
    }

    public function hasFriendRequestRecieved(User $user){
        return (bool) $this->friendsRequest()->where('id',$user->id)->count();
    }

    public function addFriend(User $user){
        $this->friendsOf()->attach($user->id);
    }

    public function deleteFriend(User $user){
        $this->friendsOfMine()->detach($user->id);
    }

    public function acceptFriendRequest(User $user){
        $this->friendsRequest()->where('id',$user->id)->first()->pivot->update([
            'accepted' => true,
        ]);
    }

    public function isFriendsWith(User $user){
        return (bool)$this->friends()->where('id',$user->id)->count();
    }

    public function hasLikedStatus(Status $status){
        return (bool)$status->likes->where('user_id',$this->id)->count();
    }
}
