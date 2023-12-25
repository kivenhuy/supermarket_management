<?php

namespace App\Http\Controllers;


use App\Models\FarmerDetails;
use App\Models\Province;
use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Uploads;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
class FarmersController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('farmer.index');
    }

        /**
     * Show the form for editing the specified resource.
     */
    public function edit(FarmerDetails $FarmerDetails)
    {
        $province = Province::all();
        $district = District::all();
        return view('farmer.create', [compact('FarmerDetails'), 'province'=> $province, 'district' => $district, 'FarmerDetails' => $FarmerDetails]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $FarmerDetails = new FarmerDetails();
        return $this -> edit($FarmerDetails); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $FarmerDetails = new FarmerDetails();
        $mytime = Carbon::now();
        $code = $this->generateRandomString();
        $data = [
            'enrollment_date'   => $mytime,
            'staff_id'   => Auth::user()->id,
            'enrollment_place'  => $request->village,
            'farmer_code'       =>$code,
            'full_name'         =>$request->full_name,
            'phone_number'      =>$request->phone_number,
            'farmer_photo'      => $request-> farmer_photo,
            'gender'            => $request-> gender,
            'country'           => 1,  
            'province'          => $request-> province,
            'district'          => $request-> district,
            'village'           => $request-> village,
        ];
        $FarmerDetails->create($data);
        return redirect()->route("farmer.index")->with('success','Farmer created successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(FarmerDetails $FarmerDetails)
    {
        //
    }

    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }


    public function upload_photo($file,$user_id)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );

        if (!empty($file)) {
            $upload = new Uploads;
            $extension = strtolower($file->getClientOriginalExtension());

            // if (
            //     env('DEMO_MODE') == 'On' &&
            //     isset($type[$extension]) &&
            //     $type[$extension] == 'archive'
            // ) {
            //     return '{}';
            // }

            if (isset($type[$extension])) {
                $upload->file_original_name = null;
                $arr = explode('.', $file->getClientOriginalName());
                for ($i = 0; $i < count($arr) - 1; $i++) {
                    if ($i == 0) {
                        $upload->file_original_name .= $arr[$i];
                    } else {
                        $upload->file_original_name .= "." . $arr[$i];
                    }
                }


                $path = $file->store('uploads/all', 'public');
                $storagePath = 'storage/' . $path;

                // dd($path);
                $size = $file->getSize();

                // Return MIME type ala mimetype extension
                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                $upload->extension = $extension;
                $upload->file_name = $storagePath;
                $upload->user_id = $user_id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                // dd($upload);
                $upload->save();
                return $upload->id;
            }
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FarmerDetails $FarmerDetails)
    {
        $FarmerDetails = new FarmerDetails();
        $photo_id = $FarmerDetails->upload_photo($FarmerDetails->farmer_photo,auth()->user()->id);
            $FarmerDetails->farmer_photo = $photo_id;
            $FarmerDetails->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FarmerDetails $FarmerDetails)
    {
        //
    }

    public function dtajax(Request $request)
    {
            $FarmerDetails = FarmerDetails::all()->sortDesc();
            $out =  DataTables::of($FarmerDetails)->make(true);
            $data = $out->getData();
            for($i=0; $i < count($data->data); $i++) {
             }
            $out->setData($data);
            return $out;
    }
}
