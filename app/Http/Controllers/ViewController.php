<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tour;
use App\Models\Location;
use App\Models\TourImage;
use App\Models\User;
use App\Models\Review;
use App\Models\BookingDetail;

class ViewController extends Controller
{
    public function homepage()
    {
        $original_tours = Tour::all()->toArray();

        $tours = array_map(function ($tour) {
            $location = Location::find(1)->where('tour_id', $tour['id'])->first();
            $numberOfLcations = Location::find(1)->where('tour_id', $tour['id'])->count();
            $tour['address'] = $location['description'] ?? 'chưa thêm';
            $tour['startDate'] = $location['startDate'] ?? 'chưa thêm';
            $tour['numberOfLocations'] = $numberOfLcations;
            return $tour;
        }, $original_tours);

        return view('user.pages.homepage', ['tours' => $tours]);
    }

    public function tourDetails($id)
    {
        // Lấy tour theo id được truyền từ parameter
        $tour = Tour::find(1)->where(['id' => $id])->first()->toArray();

        // Nếu đã đăng nhập thì thêm biến user
        if (Auth::check()) {
            $user = auth()->user();
        }

        // Lấy địa điểm bắt đầu
        $start_location = Location::find(1)->where('tour_id', $tour['id'])->first();
        // Lấy tất cả các địa điểm của tour này
        $current_locations = Location::find(1)->where('tour_id', $tour['id'])->get()->toArray();

        // Chỉnh sửa lại biến location để render dữ liệu ra map sử dụng mapbox
        $locations = array_map(function ($location) {
            $return_location['type'] = 'Point';
            $return_location['coordinates'] = [$location['longitude'], $location['latitude']];
            $return_location['description'] = $location['description'];
            $return_location['day'] = $location['day'];
            $return_location['_id'] = $location['id'];
            return (object) $return_location;
        }, $current_locations);

        // Lấy tất cả ảnh của tour này
        $images = TourImage::find(1)->where('tour_id', $tour['id'])->get();

        // Lấy tất cả hướng dẫn viên du lịch của tour này
        $guides = User::all()->where('id', $tour['guide_id'])->first();
        //dd($guides['name']);

        // Lấy tất cả các dánh giá về tour này
        $reviews = Review::all()->where('tour_id', $tour['id'])->toArray();
        // Thêm tên và ảnh vào biến reviews
        $reviews = array_map(function ($review) {
            $user = User::find($review['user_id']);

            $review['photo'] = $user['photo'];
            $review['name'] = $user['name'];

            return $review;
        }, $reviews);

        // Thêm 1 vài thông tin cần thiết
        $tour['address'] = $start_location['description'] ?? 'chưa thêm';
        $tour['startDate'] = $start_location['startDate'] ?? 'chưa thêm';
        $tour['images'] = $images;
        $tour['guide'] = $guides;

        // Nếu hết vé, tạo biến $outOfTicket = true
        $outOfTicket = false;
        if (BookingDetail::all()->where('tour_id', $tour['id'])->count() >= $tour['maxGroupSize']) {
            $outOfTicket = true;
        }

        return view(
            'user.pages.tour',
            [
                'tour' => $tour,
                'locations' => $locations,
                'user' => $user,
                'reviews' => $reviews,
                'outOfTicket' => $outOfTicket,
            ]
        );
    }

    public function account()
    {
        $user = auth()->user();

        return view('user.pages.account', ['user' => $user]);
    }

    public function myBookings()
    {
        // lấy người dùng đang đăng nhập
        $user = auth()->user();

        // Lấy các bookings của người dùng hiện tại
        $bookings = BookingDetail::all()->where('user_id', $user['id'])->toArray();
        $tour_ids = array_map(function ($booking) {
            return $booking['tour_id'];
        }, $bookings);

        // Lấy tất cả các tour có trong các bookings trên
        $tours = array_map(function ($tour_id) {
            $tour = Tour::find($tour_id);

            $location = Location::find(1)->where('tour_id', $tour['id'])->first();
            $numberOfLcations = Location::find(1)->where('tour_id', $tour['id'])->count();

            $tour['address'] = $location['description'] ?? 'chưa thêm';
            $tour['startDate'] = $location['startDate'] ?? 'chưa thêm';
            $tour['numberOfLocations'] = $numberOfLcations;

            return $tour;
        }, $tour_ids);

        return view('user.pages.my-bookings', ['tours' => $tours, 'user' => $user]);
    }
}
