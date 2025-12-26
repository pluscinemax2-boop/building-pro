<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index() { return view('admin.replies.index'); }
    public function create() { return view('admin.replies.create'); }
    public function store(Request $request) { /* ... */ }
    public function show($id) { return view('admin.replies.show', compact('id')); }
    public function edit($id) { return view('admin.replies.edit', compact('id')); }
    public function update(Request $request, $id) { /* ... */ }
    public function destroy($id) { /* ... */ }
}
