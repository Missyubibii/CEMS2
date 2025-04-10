<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\AdminRoomBookingController;
use App\Http\Controllers\RoomBookingController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('splade')->group(function () {
    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/about', function () {
        return view('about'); // view 'about' là trang bạn muốn hiển thị
    })->name('about');

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/room_bookings/create', [RoomBookingController::class, 'create'])->name('room_bookings.create');
        Route::post('/room_bookings', [RoomBookingController::class, 'store'])->name('room_bookings.store');
        Route::get('/room_bookings/timetable', [RoomBookingController::class, 'timetable'])->name('room_bookings.timetable');
        Route::delete('/room_bookings/timetable/{timetable}', [RoomBookingController::class, 'destroy'])->name('room_bookings.destroy');
        Route::get('/room_bookings/timetable/{timetable}/edit', [RoomBookingController::class, 'edit'])->name('room_bookings.edit');
        Route::put('/room_bookings/timetable/{timetable}', [RoomBookingController::class, 'update'])->name('room_bookings.update');
    });


    // Route dành cho Admin
    Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->middleware(['verified'])->name('dashboard');

        // Routes cho thiết bị học
        Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index'); // Hiển thị danh sách
        Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store'); // Thêm thiết bị
        Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit'); // Sửa thiết bị
        Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update'); // Cập nhật thiết bị
        Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy'); // Xóa thiết bị

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Thêm thiết bị
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Sửa thiết bị
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); // Cập nhật thiết bị
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // Xóa thiết bị

        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/store', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms/store', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit'); // Sửa phòng học
        Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy'); // Xóa phòng học

        // Routes cho Tòa nhà
        Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index'); // Hiển thị danh sách tòa nhà
        Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create'); // Form thêm tòa nhà
        Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store'); // Thêm tòa nhà mới
        Route::get('/buildings/{building}/edit', [BuildingController::class, 'edit'])->name('buildings.edit'); // Form chỉnh sửa tòa nhà
        Route::put('/buildings/{building}', [BuildingController::class, 'update'])->name('buildings.update'); // Cập nhật tòa nhà
        Route::delete('/buildings/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy'); // Xóa tòa nhà

        // Routes cho Cơ sở
        Route::get('/campuses', [CampusController::class, 'index'])->name('campuses.index'); // Hiển thị danh sách cơ sở
        Route::get('/campuses/create', [CampusController::class, 'create'])->name('campuses.create'); // Form thêm cơ sở
        Route::post('/campuses', [CampusController::class, 'store'])->name('campuses.store'); // Thêm cơ sở mới
        Route::get('/campuses/{campus}/edit', [CampusController::class, 'edit'])->name('campuses.edit'); // Form chỉnh sửa cơ sở
        Route::put('/campuses/{campus}', [CampusController::class, 'update'])->name('campuses.update'); // Cập nhật cơ sở
        Route::delete('/campuses/{campus}', [CampusController::class, 'destroy'])->name('campuses.destroy'); // Xóa cơ sở

        Route::get('/room-bookings', [AdminRoomBookingController::class, 'index'])->name('room_bookings.index');
        Route::get('/room-bookings/create', [AdminRoomBookingController::class, 'create'])->name('room_bookings.create');
        Route::post('/room-bookings', [AdminRoomBookingController::class, 'store'])->name('room_bookings.store');
        Route::get('/room-bookings/{roomBooking}/edit', [AdminRoomBookingController::class, 'edit'])->name('room_bookings.edit');
        Route::put('/room-bookings/{roomBooking}', [AdminRoomBookingController::class, 'update'])->name('room_bookings.update');
        Route::delete('/room-bookings/{roomBooking}', [AdminRoomBookingController::class, 'destroy'])->name('room_bookings.destroy');
        Route::get('/room-bookings/{roomBooking}/status/{status}', [AdminRoomBookingController::class, 'updateStatus'])->name('room_bookings.updateStatus');
        Route::put('/room-bookings/{roomBooking}/approve', [AdminRoomBookingController::class, 'approve'])->name('room_bookings.approve');
        Route::put('/room-bookings/{roomBooking}/reject', [AdminRoomBookingController::class, 'reject'])->name('room_bookings.reject');
        Route::put('room_bookings/{roomBooking}/returnRoom', [AdminRoomBookingController::class, 'returnRoom'])->name('room_bookings.returnRoom');

        Route::get('/room-bookings/approval', [RoomBookingController::class, 'adminApproval'])->name('admin.room_bookings.approval');
        Route::post('/room-bookings/{id}/status', [RoomBookingController::class, 'updateStatus'])->name('admin.room_bookings.updateStatus');

        // Route::resource('/repairs', RepairController::class);
    });


    // Route dành cho Giáo viên
    Route::middleware(['auth', 'role:Giáo viên'])->group(function () {
        Route::get('/teacher/dashboard', function () {
            return view('teacher.dashboard');
        })->name('teacher.dashboard');

        // Route::get('/room-bookings', [RoomBookingController::class, 'index'])->name('room_bookings.index');
        // Route::post('/room-bookings', [RoomBookingController::class, 'store'])->name('room_bookings.store');
        // Route::get('/room-bookings/{id}/edit', [RoomBookingController::class, 'edit'])->name('room_bookings.edit');
        // Route::put('/room-bookings/{id}', [RoomBookingController::class, 'update'])->name('room_bookings.update');
        // Route::delete('/room-bookings/{id}', [RoomBookingController::class, 'destroy'])->name('room_bookings.destroy');
    });




    require __DIR__ . '/auth.php';
});
