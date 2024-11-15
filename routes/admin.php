<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\BrandmodelController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\UsertypesController;
use App\Http\Controllers\admin\VehiclecolorsController;
use App\Http\Controllers\admin\VehicleController;
use App\Http\Controllers\admin\VehicleimagesController;
use App\Http\Controllers\admin\VehicletypesController;
use App\Http\Controllers\admin\ZoneController;
use App\Http\Controllers\admin\ZonecoordController;
use App\Models\Vehiclecolor;

Route::resource('brands', BrandController::class)->names('admin.brands');
Route::resource('models', BrandmodelController::class)->names('admin.models');
Route::resource('vehicles', VehicleController::class)->names('admin.vehicles');
Route::resource('vehicleimages', VehicleimagesController::class)->names('admin.vehicleimages');
Route::get('modelsbybrand/{id}', [BrandmodelController::class, 'modelsbybrand'])->name('admin.modelsbybrand');
Route::get('imageprofile/{id}/{vehicle_id}', [VehicleimagesController::class, 'profile'])->name('admin.imageprofile');
Route::resource('zones', ZoneController::class)->names('admin.zones');
Route::resource('zonecoords', ZonecoordController::class)->names('admin.zonecoords');

Route::resource('vehicletypes', VehicletypesController::class)->names('admin.vehicletypes');
Route::resource('vehiclecolors', VehiclecolorsController::class)->names('admin.vehiclecolors');
Route::resource('usertypes', UsertypesController::class)->names('admin.usertypes');

Route::resource('users', UserController::class)->names('admin.users');