<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Excel;
use App\Qgrid;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function fileUpload(Request $request)
    {
        $data = $request->all();
        if ($file = $request->hasFile('report')) {
            $file = $request->file('report');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $destinationPath = public_path() . '/report';
            $file->move($destinationPath, $fileName);
            $data['report'] = $fileName;
        }
        Excel::load('/public/report/'.$fileName, function($reader) {
            // reader methods
            $results = $reader->get();
            foreach($results as $result){
                Qgrid::create([
                    'content_id' => $result['content_id'],
                    'parent_id' => $result['parent_id'],
                    'content_type' => $result['content_type'],
                    'content' => $result['content'],
                    'content_order' => $result['content_order'],
                    'creation_date' => $result['creation_date'],
                    'change_date' => $result['change_date']
                ]);
            }
        });
        return redirect('/qgrid');
    }
}
