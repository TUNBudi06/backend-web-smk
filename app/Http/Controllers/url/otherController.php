<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\url\tb_other;
use Illuminate\Http\Request;

class otherController extends Controller
{
    private const SAMBUTAN_KEPALA_SEKOLAH_ID = 8;

    private const MAX_IMAGE_SIZE = 10240; // 10MB in KB

    public function index(Request $request)
    {
        $token = $this->getToken($request);
        $other = tb_other::whereBetween('id_link', [4, 9])->get();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.url.lainnya', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'action' => $action,
            'other' => $other,
            'token' => $token,
        ]);
    }

    public function show(Request $request)
    {
        $token = $this->getToken($request);
        $id = $request->route('id');
        $data = tb_other::findOrFail($id);

        return view('admin.page.url.lain.show', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'token' => $token,
            'data' => $data,
        ]);
    }

    public function editOther(Request $request)
    {
        $token = $this->getToken($request);
        $id = $request->route('id');
        $data = tb_other::findOrFail($id);

        return view('admin.page.url.lain.edit', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'token' => $token,
            'idData' => $id,
            'data' => $data,
        ]);
    }

    public function updateOther(Request $request)
    {
        $token = $this->getToken($request);
        $id = $request->route('id');
        $data = tb_other::findOrFail($id);

        // Check if this is a special item with image (Sambutan Kepala Sekolah, etc.)
        if ($this->requiresImageUpdate($id)) {
            $this->updateWithImage($request, $data);
        } else {
            $this->updateRegularItem($request, $data);
        }

        $data->save();

        return redirect()
            ->route('lainnya.index', ['token' => $token])
            ->with('update', 'Data berhasil diubah');
    }

    public function destroy(Request $request)
    {
        // TODO: Implement delete functionality
    }

    /**
     * Get token from session or request input
     */
    private function getToken(Request $request): ?string
    {
        return $request->session()->get('token') ?? $request->input('token');
    }

    /**
     * Check if the item requires image update (Sambutan Kepala Sekolah, etc.)
     */
    private function requiresImageUpdate(int $id): bool
    {
        return in_array($id, [8, 9]);
    }

    /**
     * Update item with image (for Sambutan Kepala Sekolah)
     */
    private function updateWithImage(Request $request, tb_other $data): void
    {
        $request->validate([
            'description' => 'required',
            'thumbnail' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:'.self::MAX_IMAGE_SIZE,
        ], [
            'description.required' => 'Kolom deskripsi wajib diisi',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB',
        ]);

        $data->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            $this->deleteOldImage($data->url);
            $data->url = $this->uploadImage($request->file('thumbnail'));
        }
    }

    /**
     * Update regular item (url, text, or file)
     */
    private function updateRegularItem(Request $request, tb_other $data): void
    {
        $request->validate([
            'type' => 'required|in:url,text,file',
        ]);

        $type = $request->type;
        $data->type = $type;

        switch ($type) {
            case 'url':
                $this->updateUrlType($request, $data);
                break;
            case 'text':
                $this->updateTextType($request, $data);
                break;
            case 'file':
                $this->updateFileType($request, $data);
                break;
        }
    }

    /**
     * Update URL type item
     */
    private function updateUrlType(Request $request, tb_other $data): void
    {
        $request->validate([
            'url' => 'required|url',
        ], [
            'url.required' => 'URL wajib diisi',
            'url.url' => 'Format URL tidak valid',
        ]);

        $data->url = $request->url;
    }

    /**
     * Update text type item
     */
    private function updateTextType(Request $request, tb_other $data): void
    {
        $request->validate([
            'description' => 'required',
        ], [
            'description.required' => 'Deskripsi wajib diisi',
        ]);

        $data->description = $request->description;
    }

    /**
     * Update file type item
     */
    private function updateFileType(Request $request, tb_other $data): void
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'file.required' => 'File wajib diisi',
            'file.mimes' => 'Format file harus: pdf, doc, atau docx',
            'file.max' => 'Ukuran file tidak boleh lebih dari 10MB',
        ]);

        $data->type = 'file';
        $data->description = $request->file('file')->getClientOriginalName();

        // Delete old file if exists
        $this->deleteOldFile($data->url);

        // Upload new file
        $data->url = $this->uploadFile($request->file('file'));
    }

    /**
     * Delete old image file
     */
    private function deleteOldImage(?string $imagePath): void
    {
        if (empty($imagePath) || $imagePath === 'img/lain/default.png') {
            return;
        }

        $fullPath = public_path($imagePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Delete old PDF/document file
     */
    private function deleteOldFile(?string $filePath): void
    {
        if (empty($filePath)) {
            return;
        }

        // Extract filename from URL
        $fileName = basename(parse_url($filePath, PHP_URL_PATH));
        $fullPath = public_path('data-pdf/'.$fileName);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Upload image file
     */
    private function uploadImage($file): string
    {
        $fileName = $file->hashName();
        $file->move(public_path('img/lain'), $fileName);

        return 'img/lain/'.$fileName;
    }

    /**
     * Upload PDF/document file
     */
    private function uploadFile($file): string
    {
        $fileContents = file_get_contents($file->getRealPath());
        $fileName = hash('sha256', $fileContents).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('data-pdf'), $fileName);

        return 'data-pdf/'.$fileName;
    }
}
