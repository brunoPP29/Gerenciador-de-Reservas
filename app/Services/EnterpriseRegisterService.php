<?php

namespace App\Services;

use App\Models\EnterpriseRegister;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class EnterpriseRegisterService{

    public function checkFields($req){
        $req->validate([
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:enterprise,name'],
            'email' => ['required', 'email', 'max:255', 'unique:enterprise,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'phone' => [
                'required',
                'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/',
                'unique:enterprise,phone'
            ]
        ]);

        return true;
    }


    public function register($req){

        $user = EnterpriseRegister::create([
            'name' => $req->name,
            'phone' => $req->phone,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);

        // cria tabelas personalizadas da empresa
        session()->put('tableOrigin', $req->email);
        session()->put('logadoenterprise', true);
        session()->put('userEnterprise', $req->name);
        $this->databaseCheck($req->email);
    }


    /**
     * Cria automaticamente:
     * - tabela de produtos
     * - tabela de reservas
     * usando o email como base do nome da tabela
     */
    public function databaseCheck($email)
    {
        // nome seguro para tabelas
        $tableBase = preg_replace('/[^a-zA-Z0-9]/', '_', $email);

        $productsTable = $tableBase . '_products';
        $reservationsTable = $tableBase . '_reservations';

        /**
         * =============================
         *   TABELA DE PRODUTOS
         * =============================
         */
        if (!Schema::hasTable($productsTable)) {

            Schema::create($productsTable, function (Blueprint $table) {

                $table->id();

                // --- PRODUTO RESERVÁVEL POR HORA ---
                $table->string('name'); // nome do produto
                $table->decimal('price_per_hour', 10, 2)->nullable(); // preço por hora
                $table->integer('duration_minutes')->default(60); // duração mínima
                $table->time('opens_at')->default('08:00'); // abre
                $table->time('closes_at')->default('22:00'); // fecha
                $table->text('description')->nullable(); // descrição
            });
        }

        /**
         * =============================
         *   TABELA DE RESERVAS
         * =============================
         */
        if (!Schema::hasTable($reservationsTable)) {

            Schema::create($reservationsTable, function (Blueprint $table) use ($productsTable) {

                $table->id();

                // referência ao produto
                $table->unsignedBigInteger('product_id');

                // data e horário da reserva
                $table->date('date');
                $table->time('start_time');
                $table->time('end_time');

                // informações do cliente (se quiser)
                $table->string('client_name')->nullable();
                $table->string('client_phone')->nullable();

                // status
                $table->string('status')->default('confirmed');

                $table->timestamps();
            });
        }

        return true;
    }
}

?>
