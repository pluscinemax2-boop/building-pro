<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\File; // Assuming File model exists for documents
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index()
    {
        // Fetch documents for the manager's building
        $buildingId = request()->user()->building_id;
        $documents = File::where('building_id', $buildingId)->latest()->paginate(10);
        
        return view('manager.documents.index', compact('documents'));
    }
}
