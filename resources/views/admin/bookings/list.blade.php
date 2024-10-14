<x-layout title="Quản lý bookings">

    <div>
        <div>
            <!-- Begin Page Content -->
            <div class="container-fluid"><br />

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Thông tin các bookings</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="{{ route('add_booking') }}">
                            <button type="submit" class="btn btn-primary ">Thêm booking
                            </button>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã booking</th>
                                        <th>Tour được đặt</th>
                                        <th>Người đặt</th>
                                        <th>Số điện thoại khách hàng</th>
                                        <th>Đã duyệt</th>
                                        <th>Giá</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($bookings as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->tourName }}</td>
                                            <td>{{ $item->userName }}</td>
                                            <td>{{ $item->phoneNumber }}</td>
                                            <td>{{ $item->approved ? 'rồi' : 'chưa' }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>

                                            <td>
                                                <button class="btn btn-info text-white" data-toggle="modal"
                                                    data-target="#details-modal-{{ $item->id }}">Xem</button>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#details-modals-{{ $item->id }}">{{ $item->approved ? 'Hủy duyệt' : 'Duyệt' }}</button>
                                                <a href="{{ route('delete_booking', ['id' => $item->id]) }}"
                                                    class="btn btn-danger">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->

    @foreach ($bookings as $item)
        <div class="modal fade" id="details-modal-{{ $item->id }}" tabindex="-1"
            aria-labelledby="details-modal-{{ $item->id }}" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="details-modal-{{ $item->id }}-label"><b>Chi tiết booking</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info " role="alert">
                            <td>
                                <b>ID:&nbsp;</b>{{ $item->id }}
                            </td><br><br>

                            <td>
                                <b>Tour_id:&nbsp;</b>{{ $item->tour_id }}
                            </td><br><br>

                            <td>
                                <b>User_id:&nbsp;</b>{{ $item->user_id }}
                            </td><br><br>

                            <td>
                                <b>Tour được đặt:&nbsp;</b>{{ $item->tourName }}
                            </td><br><br>

                            <td>
                                <b>Người đặt:&nbsp;</b>{{ $item->userName }}
                            </td><br><br>

                            <td>
                                <b>Số điện thoại:&nbsp;</b>{{ $item->phoneNumber }}
                            </td><br><br>

                            <td>
                                <b>Giá:&nbsp;</b>{{ $item->price }}
                            </td><br><br>

                            <td>
                                <b>Đã duyệt:&nbsp;</b>{{ $item->approved ? 'rồi' : 'chưa' }}
                            </td><br><br>

                            <td>
                                <b>Ngày tạo:&nbsp;</b>{{ $item->created_at }}
                            </td><br><br>

                            <td>
                                <b>Ngày cập nhật:&nbsp;</b>{{ $item->updated_at }}
                            </td><br><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!--phần update-->
    @foreach ($bookings as $item)
        <div class="modal fade" id="details-modals-{{ $item->id }}" tabindex="-1"
            aria-labelledby="details-modals-{{ $item->id }}" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="details-modals-{{ $item->id }}-label"><b>Xác nhận người dùng
                                {{ $item->approved ? 'hủy' : 'đặt' }} đơn này</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('approve_booking', ['id' => $item->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            {{ $item->approved ? 'Hủy duyệt' : 'Duyệt' }} đơn đặt tour này ?

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Đồng ý</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endforeach
</x-layout>
