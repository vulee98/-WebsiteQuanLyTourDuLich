<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

use App\Models\Review;
use App\Models\User;
use App\Models\Tour;

class ReviewController extends Controller
{
    public function review(Request $request, $tour_id, $user_id)
    {
        $review = Review::find(1);

        // Nếu có review và số lượng review vs tour_id và user_id hiện tại bằng 1 (tức là đã đánh giá rồi)
        // => ko được đánh giá nữa (tránh spam)
        if ($review != null && $review->where(['tour_id' => $tour_id, 'user_id' => $user_id])->count() == 1) {
            return redirect()->route('tour_details', [$tour_id])->with('alert', 'Bạn chỉ được đánh giá mỗi tour một lần.');
        }

        // Định nghĩa xác thực dữ liệu
        $rules = [
            'rating'        =>  ['required', 'numeric', 'min:1', 'max:5'],
            'content'       =>  ['required'],
        ];

        $fields = [
            'rating'        =>  'Đánh giá',
            'content'       =>  'Nội dung',
        ];

        // Lấy dữ liệu và xác thực
        $data = $request->all(); // lấy dữ liệu nhận được từ request

        $validator = Validator::make($data, $rules, [], $fields);

        $validator->validate();    // gọi hàm xác thực dữ liệu

        // Lấy thông tin người đánh giá và tour được đánh giá
        $user = User::all()->where('id', $user_id)->first();
        $tour = Tour::all()->where('id', $tour_id)->first();

        $review = new Review;
        $review->tour_id = $tour_id;
        $review->user_id = $user_id;
        $review->tourName = $tour->name;
        $review->userName = $user->name;
        $review->rating = $data['rating'];
        $review->content = $data['content'];

        $review->save();

        return redirect()->route('tour_details', [$tour_id])->with('alert', 'Cảm ơn bạn đã gửi đánh giá đến chúng tôi! ');
    }

    public function list()
    {
        $reviews = Review::orderBy('created_at', 'desc')->paginate();

        return view('admin.reviews.list', ['reviews' => $reviews]);
    }

    public function add_review()
    {
        return view('admin.reviews.add');
    }

    public function save_review(Request $request, $id = null)
    {
        $rules = [
            'user_id'   =>  'required',
            'tour_id'   =>  'required',
            'rating'    =>  ['required', 'numeric', 'min:1', 'max:5'],
            'content'   =>  'required',
        ];

        if ($id != null) {
            $rules['user_id'] = 'nullable';
            $rules['tour_id'] = 'nullable';
        }

        $fields = [
            'user_id'   =>  'Người đặt',
            'tour_id'   =>  'Tour được đặt',
            'rating'    =>  'Đánh giá',
            'content'   =>  'Nội dung',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules, [], $fields);

        $validator->validate();

        if ($id == null) {
            $review = Review::find(1);

            if ($review != null && $review->where(['tour_id' => $data['tour_id'], 'user_id' => $data['user_id']])->count() == 1) {
                return redirect()
                    ->route('add_review')
                    ->with('error_mesg', 'Thêm dữ liệu thất bại (Người dùng được chọn đã đánh giá tour này rồi)');
            }
        }

        try {
            unset($data["_token"]); // loại bỏ giá trị _token từ request
            if ($id == null) {

                $user = User::find($data['user_id']);
                $tour = Tour::find($data['tour_id']);

                $data['userName'] = $user['name'];
                $data['tourName'] = $tour['name'];
            }

            Review::updateOrCreate(['id' => $id], $data);

            return redirect()
                ->route('list_reviews');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()
                ->route('add_review')
                ->with('error_mesg', 'Thêm dữ liệu thất bại (Chi tiết: ' . $ex->getMessage() . ')');
        }
    }

    public function delete_review($id = null)
    {
        Review::destroy($id);
        return redirect()->back();
    }
}
