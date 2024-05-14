<?php

namespace App\Http\Controllers;

use App\Imports\MultipleSheetImport;
use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{


    public function dashboard()
    {
        return view('dashboard');
    }


    public function user(Request $request)
    {
        $data = new User;
        if ($request->get('search')) {
            $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        }

        if ($request->get('tanggal')) {
            $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        }
        //$data = $data->withTrashed();

        $data = $data->get();

        return view('user', compact('data', 'request'));
    }

    public function assets(Request $request)
    {
        $data = new User;
        if ($request->get('search')) {
            $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        }

        if ($request->get('tanggal')) {
            $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        }
        //$data = $data->withTrashed();

        $data = $data->get();

        if ($request->get('export') == 'pdf') {
            $pdf = Pdf::loadView('pdf.assets', ['data' => $data]);
            return $pdf->stream('Data_Asset.pdf');
        }

        return view('assets', compact('data', 'request'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|mimes:png,jpg,jpeg|max:2048',
            'email' => 'required|email',
            'nama'  => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $photo = $request->file('photo');
        $filename = date('Y-m-d') . $photo->getClientOriginalName();
        $patch = 'photo-user/' . $filename;

        Storage::disk('public')->put($patch, file_get_contents($photo));

        $data['email']      = $request->email;
        $data['name']       = $request->nama;
        $data['password']   = Hash::make($request->password);
        $data['image']      = $filename;


        User::create($data);

        return redirect()->route('admin.user');
    }

    public function edit(Request $request, $id)
    {
        $data = User::find($id);
        return view('edit', compact('data'));
    }

    public function detail(Request $request, $id)
    {
        $data = User::find($id);
        return view('detail', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|mimes:png,jpg,jpeg|max:2048',
            'email' => 'required|email',
            'nama'  => 'required',
            'password' => 'nullable',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $find = User::find($id);

        $data['email']      = $request->email;
        $data['name']       = $request->nama;


        if ($request->password) {
            $data['password']   = Hash::make($request->password);
        }

        $photo = $request->file('photo');

        if ($photo) {

            $filename = date('Y-m-d') . $photo->getClientOriginalName();
            $patch = 'photo-user/' . $filename;

            $data['image'] = $filename;

            if ($find->image) {
                Storage::disk('public')->delete('photo-user/' . $find->image);
            }
        }


        Storage::disk('public')->put($patch, file_get_contents($photo));

        $find->update($data);

        return redirect()->route('admin.user');
    }

    public function delete(Request $request, $id)
    {

        $data = User::find($id);
        if ($data) {
            //$data->delete();
            $data->forceDelete();
        }
        return redirect()->route('admin.user');
    }

    public function import(Request $request)
    {
        return view('import');
    }

    public function import_proses(Request $request)
    {
        try {

            Excel::import(new MultipleSheetImport(), $request->file('file'));
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
