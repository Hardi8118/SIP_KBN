<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
    use Notifiable;
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nik', 'password', 'peran'];
    protected $hidden = ['password', 'remember_token'];
    public function dataPenduduk() {
        return $this->hasOne(DataPenduduk::class, 'nik', 'nik');
    }
}