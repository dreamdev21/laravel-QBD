<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Qgrid;
use DateTime;
use Illuminate\Support\Facades\Response;

class QgridController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $sortBy = 'id';
        $sortDirection = 'ASC';
        if (request('sortby') || request('sortdir')) {
            $sortBy = request('sortby');
            $sortDirection = request('sortdir');
        }
//        $datas = Qgrid::orderBy($sortBy, $sortDirection)->paginate(6);
        $datas = Qgrid::orderBy($sortBy, $sortDirection)->get();
        $dpdatas = Qgrid::orderBy($sortBy, $sortDirection)->get();
        return view('qgrid.index',compact('datas','dpdatas'));
    }
    public function create(Request $request)
    {
        Qgrid::create([
            'content_id' => $request['content_id'],
            'parent_id' => $request['parent_id'],
            'content_type' => $request['content_type'],
            'content' => $request['content'],
            'content_order' => $request['content_order'],
//            'creation_date' => $request['creation_date'],
//            'change_date' => $request['change_date']
        ]);
        return back()->with('message', 'Flower template state changed successfull!');
    }
    public function update(Request $request, $id){
        $data = $request->all();
        unset($data['_token']);
        Qgrid::where('id', $id)->update($data);

        return back()->with('message', 'Flower template state changed successfull!');
    }
    public function delete($id){

        Qgrid::where('id', $id)->delete();
        return back()->with('message', 'Flower template state changed successfull!');
    }
    public function export_csv(){

        $data = Qgrid::orderBy( 'id')->get();

        $data_csv[0] = array('id','content_id', 'parent_id', 'content_type', 'content', 'content_order', 'creation_date', 'change_date');

        $i  = 0;

        foreach ( $data as $line ) {
            $i = $i+1;
            $data_csv[$i] = array( $line->id ,$line->content_id,$line->parent_id, $line->content_type , $line->content , $line->content_order , $line->creation_date, $line->change_date);
        }

        $date_now = new DateTime();

        $fileName = "Export-".date_format($date_now,'Y-m-d').".csv";

        $fp = fopen($fileName, 'w');

        foreach ( $data_csv as $line ) {
            fputcsv($fp, $line, ',');
        }

        fclose($fp);

        $file= public_path().'/'.$fileName;

        $headers = array(
            'Content-Type: application/csv',
        );

        return Response::download($file, 'download.csv', $headers);

    }
    public function export_json(){

        $data = Qgrid::orderBy( 'id')->get();
        header('Content-disposition: attachment; filename=download.json');
        header('Content-type: application/json');
        echo $data;

    }
}
