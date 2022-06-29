<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Advertisement;

class AdminADsController extends Controller
{
    public function index()
    {
        $Ads = Advertisement::on()->orderBy('id', 'desc')->get();
        return view('admins.advertisement.index', ['Ads' => $Ads]);
    }

    public function create()
    {
        return view('admins.advertisement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'bail|required',
            'image' => 'required',
            'link' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/images/ad', $fileName);

            Advertisement::on()->create([
                'title' => $request->get('title'),
                'image' => $fileName,
                'link' => $request->get('link')
            ]);
        }

        return redirect('/admin/advertise');
    }

    public function show($id)
    {
        $Ad = Advertisement::on()->where('id', $id)->first();
        return view('admins.advertisement.show', ['ad' => $Ad]);
    }

    public function edit($id)
    {
        $Ad = Advertisement::on()->where('id', $id)->first();
        return view('admins.advertisement.edit', ['ad' => $Ad]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'bail|required',
            'link' => 'required'
        ]);

        $ad = Advertisement::on()->find($request->get('id'));

        if (request('image') != null) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $ad->update([
                'image' => $fileName
            ]);
            $request->file('image')->storeAs('public/images/ad', $fileName);
        }

        $ad->update([
            'title' => $request->get('title'),
            'link' => $request->get('link')
        ]);

        return redirect('/admin/advertise');
    }

    public function destroy(Request $request)
    {
        foreach ($request->get('adIdArr') as $ad) {
            $ads = Advertisement::on()->find($ad);
            $ads->delete();
        }

        return $request->get('adIdArr');
    }
}
