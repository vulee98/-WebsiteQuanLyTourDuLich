<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use App\Models\BookingDetail;
use Exception;

use App\Models\Tour;
use App\Models\User;
use App\Models\Location;

class BookingDetailController extends Controller
{
    public function booking($tour_id, $user_id)
    {
        // lấy người dùng đang đăng nhập
        $user = auth()->user();

        // lấy tour đang được đặt
        $tour = Tour::find($tour_id);

        // kiểm tra xem người dùng đó đã đặt tour chưa, nếu đã đặt r thì ko cho đặt nữa (tránh spam)
        $booking = BookingDetail::find(1);

        if ($booking != null && $booking->where(['tour_id' => $tour_id, 'user_id' => $user_id])->count() == 1) {
            return redirect()->route('tour_details', [$tour_id])->with('alert', 'Đặt tour thất bại! Bạn đã đặt tour này rồi.');
        } else if (BookingDetail::all()->where('tour_id', $tour['id'])->count() >= $tour['maxGroupSize']) {
            return redirect()->route('tour_details', [$tour_id])->with('alert', 'Đặt tour thất bại! Tour này đã đạt tối đa số người tham gia.');
        }

        $data = new BookingDetail();
        $data->tour_id = $tour_id;
        $data->user_id = $user_id;
        $data->tourName = $tour['name'];
        $data->userName = $user['name'];
        $data->phoneNumber = $user['phoneNumber'];
        $data->price = $tour['price'];
        $data->approved = false;

        $data->save();
        return redirect()->route('my-bookings')->with('alert', 'Đặt tour thành công!');
    }

    public function list()
    {
        $bookings = BookingDetail::orderBy('created_at', 'desc')->paginate();

        return view('admin.bookings.list', ['bookings' => $bookings]);
    }

    public function add_booking()
    {
        return view('admin.bookings.add');
    }

    public function save_booking(Request $request, $id = null)
    {
        $rules = [
            'user_id'   =>  'required',
            'tour_id'   =>  'required',
        ];

        $fields = [
            'user_id'   =>  'Người đặt',
            'tour_id'   =>  'Tour được đặt',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules, [], $fields);

        $validator->validate();

        $booking = BookingDetail::find(1);

        // Lấy thông tin tour và người dùng đang tạo booking
        $user = User::find($data['user_id']);
        $tour = Tour::find($data['tour_id']);

        if ($booking != null && $booking->where(['tour_id' => $data['tour_id'], 'user_id' => $data['user_id']])->count() == 1) {
            return redirect()
                ->route('add_booking')
                ->with('error_mesg', 'Thêm dữ liệu thất bại (Người dùng được chọn đã đặt tour này rồi)');
        } else if (BookingDetail::all()->where('tour_id', $tour['id'])->count() >= $tour['maxGroupSize']) {
            return redirect()->route('add_booking')->with('error_mesg', 'Thêm dữ liệu thất bại! Tour này đã đạt tối đa số người tham gia.');
        }

        try {
            unset($data["_token"]); // loại bỏ giá trị _token từ request
            $booking = [];
            $booking['user_id'] = $data['user_id'];
            $booking['tour_id'] = $data['tour_id'];
            $booking['approved'] = isset($data['approved']) ? true : false;
            $booking['tourName'] = $tour['name'];
            $booking['price'] = $tour['price'];
            $booking['userName'] = $user['name'];
            $booking['phoneNumber'] = $user['phoneNumber'];

            BookingDetail::updateOrCreate(['id' => $id], $booking);

            return redirect()
                ->route('list_bookings');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()
                ->route('add_booking')
                ->with('error_mesg', 'Thêm dữ liệu thất bại (Chi tiết: ' . $ex->getMessage() . ')');
        }
    }

    public function approve_booking($id)
    {
        $booking = BookingDetail::find($id);
        $booking->approved = !$booking->approved;
        $booking->save();
        return redirect()->back();
    }

    public function delete_booking($id = null)
    {
        BookingDetail::destroy($id);
        return redirect()->back();
    }

    public function bookings_on_tour()
    {
        $tours = Tour::all();
    
        $data = [];
        foreach ($tours as $key => $tour) {
            // Lấy Location tương ứng với tour_id, kiểm tra nếu tồn tại
            $location = Location::where('tour_id', $tour->id)->first();
            $startDate = $location ? $location->startDate : 'N/A'; // Sử dụng giá trị mặc định nếu không tìm thấy
    
            // Lấy các BookingDetail theo tour_id
            $bookings = BookingDetail::where('tour_id', $tour->id)->get();
    
            $totalMoney = 0;
            $approvedOrderQuantity = 0;
            foreach ($bookings as $booking) {
                $totalMoney += $booking->price;
                if ($booking->approved) {
                    $approvedOrderQuantity++;
                }
            }
    
            $data[$key] = [
                'tourName' => $tour->name,
                'startDate' => $startDate,
                'maxGroupSize' => $tour->maxGroupSize,
                'numberOfPeopleBooked' => $bookings->count(),
                'approvedOrderQuantity' => $approvedOrderQuantity,
                'totalMoney' => $totalMoney,
            ];
        }
    
        return view('admin/bookings/bookings_on_tour', ['data' => $data]);
    }
    
}
