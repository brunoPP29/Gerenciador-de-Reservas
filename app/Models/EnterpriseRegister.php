<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class EnterpriseRegister extends Model{
        protected $table = 'enterprise';
        
        public $timestamps = false; 

        protected $fillable = [
            'name',
            'password',
            'email',
            'phone'
];
    }

?>


?>