<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Dump;
use App\Traits\DatatablTrait;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Session;


class DatabaseBackupController extends Controller
{
    use DatatablTrait;

    public function index()
    {
        return view('admin.settings.database-backup.database_backup');
    }

    public function create()
    {

        return response()->json([
            'html' => view('admin.settings.database-backup.database_backup')->render()
        ]);
    }

    public function List(Request $request)
    {


        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'created_at',
        );

        $totalData = Dump::count();
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = Dump::when($search, function ($query, $search) {
            return $query->whereDate('created_at', '=', date('Y-m-d', strtotime($search)));
        });


        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {


            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }


            $d = LogActivity::commonDateFromatType() . ' ' . 'h:i';


            $row['date'] = date($d, strtotime($item->created_at));

            $row['action'] = $this->action([
                'download' => route('database-backup.show', $item->id),
                'restore' => route('database-backup.restore', $item->id),
            ]);

            $data[] = $row;

        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return response()->json($json_data);
    }



    public function show($id)
    {
        $filename = Dump::findorfail($id)->file_name;
        return response()->download(storage_path("dumps/{$filename}"));
    }


    public function restore($id)
    {
        $filename = Dump::findorfail($id)->file_name;
        $restore_file = storage_path() . '/dumps/' . $filename;
        $server_name = env("DB_HOST");
        $username = env("DB_DATABASE");
        $password = env("DB_USERNAME");
        $database_name = env("DB_PASSWORD");

        $cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";

        exec($cmd);

        Session::flash('success', "تمت استعادة النسخة الاحتياطية بنجاح");
        return redirect()->back();
    }

}
