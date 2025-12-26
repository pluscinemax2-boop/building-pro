<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index() { return view('admin.threads.index'); }
    public function create() { return view('admin.threads.create'); }
    public function store(Request $request) { /* ... */ }
    public function show($id) { return view('admin.threads.show', compact('id')); }
    public function edit($id) { return view('admin.threads.edit', compact('id')); }
    public function update(Request $request, $id) { /* ... */ }
    public function destroy($id) { /* ... */ }
}
