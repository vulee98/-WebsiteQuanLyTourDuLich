<?php

namespace App\Http\Controllers;


use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Lấy danh sách người dùng
    public function list()
    {
        $users = User::orderBy('created_at', 'desc')->paginate();

        return view('admin.users.list')->with('users', $users);
    }

    // Lấy form thêm người dùng
    function add_user()
    {
        return view('admin.users.add');
    }

    // Xóa người dùng
    function delete_user($id = null)
    {
        User::destroy($id);
        return redirect()->back();
    }

    // Xử lý thêm hoặc cập nhật người dùng
    function save_user(Request $request, $id = null)
    {
        $rules = [
            'name'              =>      ['required'],
            'email'             =>      ['required', 'email', 'unique:users'],
            'password'          =>      ['required', 'min:4'],
            'photo'             =>      ['nullable'],
            'phoneNumber'       =>      ['required', 'unique:users'],
            'confirmPassword'   =>      ['same:password'],
            'role'              =>      ['required'],
        ];

        // Lấy người dùng đang được cập nhật
        $user = User::find($id);

        // Nếu người dùng không thay đổi email và phoneNumber => xóa validate cho 2 field này
        if ($request->email == $user['email']) {
            unset($rules['email']);
        }

        if ($request->phoneNumber == $user['phoneNumber']) {
            unset($rules['phoneNumber']);
        }

        // Nêu là cập nhật thì set lại các validation
        if (isset($id)) {
            $rules['password'] = ['nullable'];
            $rules['role'] = ['nullable'];
        }

        $fields = [
            'name'              =>      'Tên người dùng',
            'email'             =>      'Email',
            'password'          =>      'Mật khẩu',
            'confirmPassword'   =>      'Xác nhận mật khẩu',
            'photo'             =>      'Ảnh đại diện',
            'phoneNumber'       =>      'Số điện thoại',
            'role'              =>      'Chức vụ',
        ];

        // lấy dữ liệu nhận được từ request
        $data = $request->all();

        // loại bỏ các giá trị null
        $data = array_filter($data, fn ($value) => !is_null($value) && $value !== '');

        // Nếu thêm người dùng mới cần validate
        $validator = Validator::make($data, $rules, [], $fields);

        $validator->validate();    // gọi hàm xác thực dữ liệu

        try {
            $user = [];
            $user["name"] = $request->name;
            $user["email"] = $request->email;
            $user["password"] = Hash::make($request->password);
            // Nhận file ảnh đại diện tải lên
            $file = $request->file('photo');
            if ($file != null) {
                $filename = $file->hashName(); // Tạo tên file ngầu nhiên
                $file->storeAs('/public/img/users', $filename); // lưu vào đường dân /public/img/users
                $user["photo"] = $filename;
            }
            $user["phoneNumber"] = $request->phoneNumber;
            $user["role"] = $request->role;
            User::updateOrCreate(['id' => $id], $user);

            return redirect()
                ->route('list_users');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()
                ->route('add_user')
                ->with('error_mesg', 'Thêm dữ liệu thất bại (Chi tiết: ' . $ex->getMessage() . ')');
        }
    }

    // Lấy form đăng nhập
    public function loginForm()
    {
        return view('user.auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // validate dữ liệu
        $userData = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        // xác thực đăng nhập
        if (Auth::attempt($userData)) {
            $request->session()->regenerate();

            return redirect()->route('homepage');
        } else {
            return back()->withErrors([
                'error' => 'Email hoặc mật khẩu không chính xác. Vui lòng thử lại.',
            ]);
        }
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Lấy form đăng ký
    public function signupForm()
    {
        return view('user.auth.signup');
    }

    // Xứ lý đăng ký tài khoản
    public function signup(Request $request)
    {
        $rules = [
            'name'              =>      ['required'],
            'email'             =>      ['required', 'email', 'unique:users'],
            'phoneNumber'       =>      ['required', 'unique:users'],
            'password'          =>      ['required', 'min:4'],
            'confirmPassword'   =>      ['same:password'],
        ];

        $fields = [
            'name'              =>      'Tên người dùng',
            'email'             =>      'Email',
            'phoneNumber'       =>      'Số điện thoại',
            'password'          =>      'Mật khẩu',
            'confirmPassword'   =>      'Xác nhận mật khẩu',
        ];

        $data = $request->all(); // lấy dữ liệu nhận được từ request

        // Nếu thêm người dùng mới cần validate
        $validator = Validator::make($data, $rules, [], $fields);

        $validator->validate();    // gọi hàm xác thực dữ liệu

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            // Nhận file ảnh đại diện tải lên
            $user->role = 'user';
            $user->photo = 'default.jpeg';
            $user->phoneNumber = $request->phoneNumber;
            $user->save();

            return redirect()
                ->route('login');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()
                ->route('add_user')
                ->with('error_mesg', 'Đăng ký thất bại (Chi tiết: ' . $ex->getMessage() . ')');
        }
    }

    public function changeInfo(Request $request)
    {
        $rules = [
            'name'              =>      ['required', 'min:2'],
            'email'             =>      ['email', 'unique:users'],
            'phoneNumber'       =>      ['min:10', 'unique:users'],
        ];

        // Lấy người dùng hiện tại
        $user = auth()->user();
        $current_user = User::find($user->id);

        // Nếu người dùng không thay đổi email và phoneNumber => xóa validate cho 2 field này
        if ($request->email == $user['email']) {
            unset($rules['email']);
        }

        if ($request->phoneNumber == $user['phoneNumber']) {
            unset($rules['phoneNumber']);
        }

        $fields = [
            'name'              =>      'Tên người dùng',
            'email'             =>      'Email',
            'phoneNumber'       =>      'Số điện thoại',
        ];

        // Lấy các dữ liệu thay đổi
        $data = $request->all();

        // validate
        $validator = Validator::make($data, $rules, [], $fields);

        $validator->validate();    // gọi hàm xác thực dữ liệu
        try {
            // Lưu dữ liệu
            $current_user->email = $data['email'];
            $current_user->name = $data['phoneNumber'];
            $current_user->name = $data['name'];
            // Nhận file ảnh đại diện tải lên
            $file = $request->file('photo');
            if ($file != null) {
                $filename = $file->hashName(); // Tạo tên file ngầu nhiên
                $file->storeAs('/public/img/users', $filename); // lưu vào đường dân /public/img/users
                $current_user->photo = $filename;
            }
            $current_user->save();

            return redirect()->route('account');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()
                ->route('account')
                ->with('error_mesg', 'Thay đổi thông tin thất bại (Chi tiết: ' . $ex->getMessage() . ')');
        }
    }

    public function changePassword(Request $request)
    {
        // Lấy người dùng hiện tại
        $user = auth()->user();
        $current_user = User::find($user->id);

        // Lấy dữ liệu nhập vào
        $data = $request->all();

        $rules = [
            'currentPassword'   =>      ['required', 'min:4'],
            'newPassword'       =>      ['required', 'min:4'],
            'confirmPassword'   =>      ['required', 'same:newPassword'],
        ];

        $fields = [
            'currentPassword'   =>      'Mật khẩu hiện tại',
            'newPassword'       =>      'Mật khẩu',
            'confirmPassword'   =>      'Xác nhận mật khẩu',
        ];

        // Nếu thêm người dùng mới cần validate
        $validator = Validator::make($data, $rules, [], $fields);

        $validator->validate();    // gọi hàm xác thực dữ liệu

        if (!Auth::attempt(['email' => $current_user['email'], 'password' => $data['currentPassword']])) {
            return redirect()->route('account')->with('currentPasswordError', 'Mật khẩu hiện tại không chính xác');
        }

        try {
            $current_user->password = Hash::make($data['newPassword']);

            $current_user->save();

            return redirect()->route('account')->with('success', 'Đổi mật khẩu thành công.');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()
                ->route('account')
                ->with('error_mesg', 'Thay đổi mật khẩu thất bại (Chi tiết: ' . $ex->getMessage() . ')');
        }
    }
}
