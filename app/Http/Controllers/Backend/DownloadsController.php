<?php

namespace App\Http\Controllers\Backend;

use App\Download;
use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DownloadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.downloads.index', [
            'downloads' => Download::paginate(15)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:150|min:5',
            'link' => 'required|max:250|min:10',
            'file_size' => 'required|max:100',
            'image_id' => 'nullable'
        ]);

        Download::create($data);

        return redirect()->back()->with('success', __('backend/notification.form-submit.success'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('backend.downloads.create', [
            'images' => Image::where('model', Download::class)->orderByDesc('id')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.downloads.edit', [
            'download' => Download::findOrFail($id),
            'images' => Image::where('model', Download::class)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:150',
            'link' => 'required|max:250',
            'file_size' => 'required',
            'image_id' => 'nullable '
        ]);

        $download = Download::findOrFail($id);
        $download->update($data);

        return redirect()->back()->with('success', __('backend/notification.form-submit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $download = Download::findOrFail($id);
        $download->delete();
        return back()->with('success', __('backend/notification.form-submit.success'));
    }
}
