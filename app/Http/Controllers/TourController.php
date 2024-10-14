<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tour;
use App\Models\TourImage;
use App\Models\User;
use App\Helper\File;

class TourController extends Controller
{
    use File;

    public function list()
    {
        // Lấy danh sách tất cả các tour và phân trang
        $tours = Tour::orderBy('created_at', 'desc')->paginate();

        // Lấy tất cả ảnh của tour, địa điểm, và hướng dẫn viên
        $tour_images = TourImage::all()->toArray();
        $locations = Location::all()->toArray();
        $guides = User::where('role', 'guide')->get()->toArray();

        return view('admin.tours.list', [
            'tours' => $tours, 
            'tour_images' => $tour_images, 
            'locations' => $locations, 
            'guides' => $guides
        ]);
    }

    public function add_tour()
    {
        return view('admin.tours.add');
    }

    public function save_tour(Request $request, $id = null)
    {
        $rules = [
            'name'                  => ['nullable'],
            'price'                 => ['nullable', 'numeric', 'max:99999999'],
            'duration'              => ['nullable', 'numeric'],
            'difficulty'            => ['nullable'],
            'imageCover'            => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images'                => ['nullable', 'array'], // Đảm bảo rằng 'images' là một mảng
            'maxGroupSize'          => ['nullable'],
            'summary'               => ['nullable'],
            'description'           => ['nullable'],
            'guide_id'              => ['required'],
        ];

        $fields = [
            'name'                  => 'Tên tour',
            'price'                 => 'Giá',
            'duration'              => 'Chuyến đi trong vòng',
            'difficulty'            => 'Độ khó',
            'imageCover'            => 'Ảnh bìa',
            'images'                => 'Các hình ảnh của tour',
            'maxGroupSize'          => 'Số lượng thành viên tối đa',
            'summary'               => 'Tóm tắt',
            'description'           => 'Mô tả',
            'guide_id'              => 'Hướng dẫn viên du lịch'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules, [], $fields);
        $validator->validate(); 

        try {
            // Nhận file ảnh bìa tải lên
            if ($imageCoverFile = $request->file('imageCover')) {
                $path = 'tours';
                $url = $this->file($imageCoverFile, $path, 500, 500); // Lưu ảnh bìa với kích thước 500x500
                $data['imageCover'] = $url;
            }

            // Nhận files các ảnh của tour tải lên
            $images = $request->file('images');
            if ($images != null) {
                foreach ($images as $key => $file) {
                    $path = 'tours';
                    $url = $this->file($file, $path, 2000, 1333); // Lưu từng ảnh với kích thước 2000x1333
                    $new_images[$key]['name'] = $url;
                }
            }

            unset($data["_token"]); 
            $newTour = Tour::updateOrCreate(['id' => $id], $data);

            // Lưu khóa tour_id vào biến $new_images để thêm vào bảng tour_images
            if ($images != null) {
                foreach ($new_images as $key => $value) {
                    $new_images[$key]['tour_id'] = $newTour->id;
                }
                TourImage::insert($new_images); // Lưu các hình ảnh vào bảng tour_images
            }

            // Lưu locations (địa điểm)
            if (isset($data['numberOfLocations']) && $data['numberOfLocations'] > 0) {
                for ($i = 0; $i < $data['numberOfLocations']; $i++) {
                    $locations[$i]['longitude'] = $data['longitude' . $i];
                    $locations[$i]['latitude'] = $data['latitude' . $i];
                    $locations[$i]['startDate'] = $data['startDate' . $i];
                    $locations[$i]['day'] = $data['day' . $i];
                    $locations[$i]['description'] = $data['description' . $i];
                    $locations[$i]['tour_id'] = $newTour->id;
                }
                Location::insert($locations); // Lưu các địa điểm vào bảng locations
            }

            return redirect()->route('list_tours');
        } catch (Exception $ex) {
            return redirect()->route('add_tour')->with('error_mesg', 'Thêm dữ liệu thất bại (Chi tiết: ' . $ex->getMessage() . ')');
        }
    }

    public function delete_tour($id = null)
    {
        Tour::destroy($id); // Xóa tour dựa trên ID
        return redirect()->back();
    }
}
