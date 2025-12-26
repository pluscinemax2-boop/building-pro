<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        // Delete file from storage
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
        return redirect()->route('building-admin.documents.index')->with('success', 'Document deleted successfully.');
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Document::orderByDesc('created_at');
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }
        $documents = $query->get();
        return view('building-admin.documents.index', compact('documents', 'search'));
    }

    public function create()
    {
        return view('building-admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240', // 10MB
                'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt,zip,csv',
            ],
        ], [
            'file.mimes' => 'Only PDF, JPG, PNG, DOC, DOCX, XLS, XLSX, TXT, ZIP, CSV files are allowed.',
            'file.max' => 'File size must be 10MB or less.',
        ]);
        $file = $request->file('file');
        $path = $file->store('documents', 'public');
        $document = Document::create([
            'name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
            'access' => 'private',
            'version' => 1,
        ]);
        return redirect()->route('building-admin.documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        $path = Storage::disk('public')->path($document->file_path);
        return response()->download($path, $document->name);
    }

    public function newVersion($id)
    {
        $document = Document::findOrFail($id);
        return view('building-admin.documents.version', compact('document'));
    }

    public function storeVersion(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file',
        ]);
        $parent = Document::findOrFail($id);
        $file = $request->file('file');
        $path = $file->store('documents', 'public');
        $version = $parent->versions()->count() + 2;
        $doc = Document::create([
            'name' => $parent->name,
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
            'access' => $parent->access,
            'version' => $version,
        ]);
        return redirect()->route('building-admin.documents.index')->with('success', 'New version uploaded.');
    }
}
