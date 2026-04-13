<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RfqTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RfqTemplateController extends Controller
{
    public function index()
    {
        $templates = RfqTemplate::with('uploader')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($t) => [
                'id'          => $t->id,
                'title'       => $t->title,
                'description' => $t->description,
                'file_name'   => $t->file_name,
                'file_url'    => Storage::url($t->file_path),
                'is_active'   => $t->is_active,
                'uploaded_by' => $t->uploader?->name,
                'created_at'  => $t->created_at,
            ]);

        return response()->json(['success' => true, 'templates' => $templates]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|mimes:xlsx,xls,csv|max:10240',
            'is_active'   => 'nullable|boolean',
        ]);

        $file     = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->storeAs('rfq-templates', time() . '_' . $fileName, 'public');

        $template = RfqTemplate::create([
            'title'       => $request->title,
            'description' => $request->description,
            'file_name'   => $fileName,
            'file_path'   => $filePath,
            'is_active'   => $request->boolean('is_active', true),
            'uploaded_by' => Auth::id(),
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Template berhasil diupload.',
            'template' => $template,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $template = RfqTemplate::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
            'file'        => 'nullable|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active', $template->is_active),
        ];

        // Jika ada file baru, hapus lama dan upload baru
        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($template->file_path)) {
                Storage::disk('public')->delete($template->file_path);
            }
            $file             = $request->file('file');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $file->storeAs('rfq-templates', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        $template->update($data);

        return response()->json([
            'success'  => true,
            'message'  => 'Template berhasil diperbarui.',
            'template' => $template,
        ]);
    }

    public function destroy($id)
    {
        $template = RfqTemplate::findOrFail($id);

        if (Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }

        $template->delete();

        return response()->json(['success' => true, 'message' => 'Template dihapus.']);
    }
}