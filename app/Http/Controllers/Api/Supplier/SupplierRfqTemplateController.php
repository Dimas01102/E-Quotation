<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\RfqTemplate;
use Illuminate\Support\Facades\Storage;

class SupplierRfqTemplateController extends Controller
{
    /**
     * List semua template yang aktif, tampil untuk SEMUA supplier
     */
    public function index()
    {
        $templates = RfqTemplate::where('is_active', true)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($t) => [
                'id'          => $t->id,
                'title'       => $t->title,
                'description' => $t->description,
                'file_name'   => $t->file_name,
                'file_url'    => Storage::url($t->file_path),
                'created_at'  => $t->created_at,
            ]);

        return response()->json(['success' => true, 'templates' => $templates]);
    }

    /**
     * Download template file
     */
    public function download($id)
    {
        $template = RfqTemplate::where('is_active', true)->findOrFail($id);

        if (!Storage::disk('public')->exists($template->file_path)) {
            return response()->json(['message' => 'File tidak ditemukan.'], 404);
        }

        return response()->download(
            storage_path('app/public/' . $template->file_path),
            $template->file_name
        );
    }
}