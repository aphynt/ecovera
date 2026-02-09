<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::latest()->paginate(10);
        return view('admin.complaint.index', compact('complaints'));
    }

    public function show($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('admin.complaint.show', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->status = $request->status;
        $complaint->save();

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
