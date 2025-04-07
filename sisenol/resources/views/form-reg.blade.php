<?php
if (AdminController::checkAdminBD()) {
    return view('admin.dashboard');
} else {
    return view('form-login');
}