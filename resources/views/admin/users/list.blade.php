<x-layout title="Quản lý người dùng">

    <div>
        <div>
            <!-- Begin Page Content -->
            <div class="container-fluid"><br />

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Thông tin người dùng</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="{{ route('add_user') }}"><button type="submit" class="btn btn-primary ">Thêm người
                                dùng
                            </button></a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã người dùng</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Ảnh đại diện</th>
                                        <th>Chức vụ</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày sửa</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>

                                            <td><img src="/storage/img/users/{{ $item->photo }}" width="100px"
                                                    alt="{{ $item->photo }}" /></td>

                                            <td>{{ $item->role }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>

                                            <td>
                                                <button class="text-white btn btn-info" data-toggle="modal"
                                                    data-target="#details-modal-{{ $item->id }}">Xem</button>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#details-modals-{{ $item->id }}">Cập nhật</button>
                                                <a href="{{ route('delete_user', ['id' => $item->id]) }}"
                                                    class="btn btn-danger">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->


    {{-- Xem chi tiết người dùng --}}
    @foreach ($users as $item)
        <div class="modal fade" id="details-modal-{{ $item->id }}" tabindex="-1"
            aria-labelledby="details-modal-{{ $item->id }}" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="details-modal-{{ $item->id }}-label"><b>Chi tiết người
                                dùng</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info " role="alert">
                            <td><b>ID:&nbsp;</b>{{ $item->id }}</td><br><br>
                            <td><b>Họ và tên:&nbsp;</b>{{ $item->name }}</td><br><br>
                            <td><b>Email:&nbsp;</b>{{ $item->email }}</td><br><br>

                            <td>
                                <b>Ảnh đại diện:&nbsp;</b>
                                <div>
                                    <img src="/storage/img/users/{{ $item->photo }}" width="80%"
                                        alt="{{ $item->photo }}" />
                                </div>
                            </td><br><br>

                            <td><b>Số điện thoại:&nbsp;</b>{{ $item->phoneNumber }}</td><br><br>

                            <td><b>Chức vụ:&nbsp; </b>{{ $item->role }}</td>
                            <br><br>

                            <td><b>Ngày tạo:&nbsp;</b>{{ $item->created_at }}</td><br><br>
                            <td><b>Ngày cập nhật:&nbsp; </b>{{ $item->updated_at }}</td><br><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach




    <!--phần update-->
    @foreach ($users as $item)
        <div class="modal fade" id="details-modals-{{ $item->id }}" tabindex="-1"
            aria-labelledby="details-modals-{{ $item->id }}" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="details-modals-{{ $item->id }}-label"><b>Cập nhật thông tin
                                người dùng</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('save_user', ['id' => $item->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <x-input name="name" label="Tên người dùng" value="{{ $item->name ?? '' }}" />
                            <x-input name="email" label="Email" type="email" value="{{ $item->email ?? '' }}" />
                            <x-input name="password" label="Mật khẩu" type="password" />
                            <x-input name="confirmPassword" label="Xác nhận mật khẩu" type="password" />
                            <x-input name="photo" label="Ảnh đại diện" type="file" />
                            <x-input name="phoneNumber" label="Số điện thoại" value="{{ $item->phoneNumber }}" />
                            <x-input name="role" label="Chức vụ" element='select' selected="{{ $item->role ?? '' }}"
                                data="admin,user,guide" />

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endforeach
</x-layout>
