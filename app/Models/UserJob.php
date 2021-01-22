<?php
 namespace App\Models;
 use Illuminate\Database\Eloquent\Model;
 
 class UserJob extends Model{
 protected $table = 'tbluserjob';
 // column sa table
 protected $fillable = [
 'jobid','jobName'
 ];

public $timestamps = false;

 protected $primaryKey = 'jobid';

 
}