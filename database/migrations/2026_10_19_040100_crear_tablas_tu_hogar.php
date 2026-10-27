<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Campos extra en la tabla users (creada por Laravel)
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('empleado')->after('password'); // 'administrador' | 'empleado'
            $table->string('puesto')->nullable()->after('role');
            $table->decimal('sueldo_base', 10, 2)->default(0)->after('puesto');
            $table->decimal('comisiones', 10, 2)->default(0)->after('sueldo_base');
        });

        // 2) Turnos: registro de inicio y fin de turno de cada empleado
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->dateTime('inicio');
            $table->dateTime('fin')->nullable(); // null = turno todavía abierto
            $table->timestamps();
        });

        // 3) Proveedores
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('contacto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // 4) Clientes
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // 5) Productos del Home Center
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
        });

        // 6) Ventas a clientes
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('user_id')->constrained('users'); // quién registró la venta
            $table->unsignedInteger('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('total', 12, 2);
            $table->dateTime('fecha');
            $table->timestamps();
        });

        // 7) Pedidos a proveedores
        Schema::create('pedidos_proveedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->foreignId('producto_id')->constrained('productos');
            $table->unsignedInteger('cantidad');
            $table->decimal('costo_unitario', 10, 2);
            $table->decimal('total', 12, 2);
            $table->string('estado')->default('pendiente'); // pendiente | recibido
            $table->date('fecha');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Se borran en orden inverso por las llaves foráneas
        Schema::dropIfExists('pedidos_proveedores');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('turnos');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'puesto', 'sueldo_base', 'comisiones']);
        });
    }
};
