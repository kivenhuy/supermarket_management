<?php

namespace App\Http\Controllers;

use App\Models\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PersonalInformationController extends Controller
{
    public function index()
    {
        $user_data = Session::get('user_data');
        $address_data = Session::get('address_data');
        // dd($address_data);
        return view('personal_information.index', compact('user_data','address_data'));
    }

    public function update(Request $request)
    {
        $logo_url = null;
        if($request->logo_url != null);
        {
            $logo_url = $this->upload_photo($request->logo,Auth::user()->id);
        }
       
        // dd($logo_url);
        $data_info =[
            'user_id'=>Auth::user()->ecom_user_id,
            'name'=>$request->name,
            'phone'=>$request->phone,
            'new_password'=>$request->new_password,
            'confirm_password'=>$request->confirm_password,
            'photo'=>$logo_url,
        ];
        // dd($data_info);
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/personal_supermarket_information/update';
            $response = Http::post($signupApiUrl,$data_info);
            // dd($response->body());
            $data_response = (json_decode($response)->data);
            if(json_decode($response)->result)
            {
                $user_data = $data_response->user_data;
            }
           
        }
        catch(\Exception $exception) {
            
        }
        Session::put('user_data', $user_data);
        return $this->index();
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
            $upload = new Uploads();
            $extension = strtolower($file->getClientOriginalExtension());

            // if (
            //     env('DEMO_MODE') == 'On' &&
            //     isset($type[$extension]) &&
            //     $type[$extension] == 'archive'
            // ) {
            //     return '{}';
            // }
            // return $extension;
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

                
                $path = $file->store('assets/img_upload', 'public');

                // dd($path);
                $size = $file->getSize();

                // Return MIME type ala mimetype extension
                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                $upload->extension = $extension;
                $upload->file_name = $path;
                $upload->user_id = $user_id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                
                // dd($upload);
                $upload->save();
                return $upload->file_name;
            }
        }
    }
}
