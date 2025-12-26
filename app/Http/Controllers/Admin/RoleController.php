<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() { return view('admin.roles.index'); }
    public function create() { return view('admin.roles.create'); }
    public function store(Request $request) { /* ... */ }
    public function show($id) { return view('admin.roles.show', compact('id')); }
    public function edit($id) { return view('admin.roles.edit', compact('id')); }
    public function update(Request $request, $id) { /* ... */ }
    public function destroy($id) { /* ... */ }
}
