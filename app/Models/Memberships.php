<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memberships extends Model {
   protected $table = "memberships";

    protected $fillable = [
    "user_id",
    "order_id",
    "username",
    "kelas",
    "start_date",
    "expired_date",
    "total_durations",
    "status",
];

}
?>