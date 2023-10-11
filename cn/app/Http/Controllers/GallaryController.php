<?php

namespace App\Http\Controllers;

use App\Gallary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GallaryController extends Controller
{
    public function read() {
        $images = Gallary::query()->get();

        return response()->json([
            'images'=>$images,
        ]);
    }

    public function upload(Request $request) {
        if(!Auth::check() || Auth::user()->role != "admin") {
            return response()->json([
                'message' => 'please, login first or login to admin',
            ], 401);
        }

        $request->validate([
            'images' => 'required',
            'images.*' => 'mimes:jpg,png'
        ]);

        foreach($request->file('images') as $file) {
            // 이미지 저장 코드
            $fileName = $file->getClientOriginalName();
            $extension = $file->extension();
            $name = time().'_'.$fileName;
            $imagePath = public_path().'/files/'.$name;

            $file->move(public_path().'/files/', $name);

            // 썸네일 생성 코드
            if($extension === "png") {
                $img = imagecreatefrompng($imagePath);
            } else {
                $img = imagecreatefromjpeg($imagePath);
            }

            $width  = imagesx($img);
            $height = imagesy($img);
            $centreX = round($width / 2);
            $centreY = round($height / 2);

            $cropWidth  = 300;
            $cropHeight = 300;
            $cropWidthHalf  = round($cropWidth / 2);
            $cropHeightHalf = round($cropHeight / 2);

            $x1 = max(0, $centreX - $cropWidthHalf);
            $y1 = max(0, $centreY - $cropHeightHalf);

            $thumb = imagecreatetruecolor(300, 300);

            imagecopy($thumb, $img, 0, 0, $x1, $y1, 300, 300);

            imagedestroy($img);

            $thumbName = 'thumb_'.time().'_'.$fileName;
            $thumbPath = public_path().'/files/'.$thumbName;

            if($extension === "png") {
                imagepng($thumb, $thumbPath);
            } else {
                imagejpeg($thumb, $thumbPath);
            }

            // 저장된 이미지와 썸네일 파일 이름을 db에 저장
            Gallary::query()->create(['image'=>$name, 'thumbnail'=>$thumbName]);
        }

        return response()->json([
            'message'=>'success'
        ]);
    }

    public function getImage($image) {
        return response()->file(public_path().'/files/'.$image);
    }
}
