<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index() { return view('admin.permissions.index'); }
    public function create() { return view('admin.permissions.create'); }
    public function store(Request $request) { /* ... */ }
    public function show($id) { return view('admin.permissions.show', compact('id')); }
    public function edit($id) { return view('admin.permissions.edit', compact('id')); }
    public function update(Request $request, $id) { /* ... */ }
    public function destroy($id) { /* ... */ }
}
