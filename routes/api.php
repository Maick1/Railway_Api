<?php

use App\Http\Controllers\Api\studentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/students", [studentController::class,"index"])->name("lista");

Route::get("/students/{id}", [studentController::class,"show"])->name("Buscar");

Route::post("/students", [studentController::class,"store"])->name("Agregar");

Route::put("/students/{id}",[studentController::class,"update"])->name("Actualizar");

Route::patch("/students/{id}",[studentController::class,"updateParcial"])->name("Actualizar_Patch");

Route::delete("/students/{id}", [studentController::class,"destroy"])->name("Eliminar");
