<x-layout title="Quản lý đánh giá">

    <div>
        <div>
            <!-- Begin Page Content -->
            <div class="container-fluid"><br />

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Thông tin các đánh giá</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="{{ route('add_review') }}">
                            <button type="submit" class="btn btn-primary ">Thêm đánh giá
                            </button>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã đánh giá</th>
                                        <th>Tour được đánh giá</th>
                                        <th>Người đánh giá</th>
                                        <th>Số sao</th>
                                        <th>Nội dung</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($reviews as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->tourName }}</td>
                                            <td><x-user-select disabled selected="{{ $item->user_id }}" /></td>
                                            <td>{{ $item->rating }}</td>
                                            <td>{{ $item->content }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>

                                            <td>
                                                <button class="btn btn-info text-white" data-toggle="modal"
                                                    data-target="#details-modal-{{ $item->id }}">Xem</button>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#details-modals-{{ $item->id }}">Cập nhật</button>
                                                <a href="{{ route('delete_review', ['id' => $item->id]) }}"
                                                    class="btn btn-danger">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $reviews->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->

    @foreach ($reviews as $item)
        <div class="modal fade" id="details-modal-{{ $item->id }}" tabindex="-1"
            aria-labelledby="details-modal-{{ $item->id }}" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="details-modal-{{ $item->id }}-label"><b>Chi tiết đánh
                                giá</b>
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
                                <b>Tour được đánh giá:&nbsp;</b>{{ $item->tourName }}
                            </td><br><br>

                            <td>
                                <b>Người đánh giá:&nbsp;</b>{{ $item->userName }}
                            </td><br><br>

                            <td>
                                <b>Số sao:&nbsp;</b>{{ $item->rating }}
                            </td><br><br>

                            <td>
                                <b>Nội dung:&nbsp;</b>{{ $item->content }}
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
    @foreach ($reviews as $item)
        <div class="modal fade" id="details-modals-{{ $item->id }}" tabindex="-1"
            aria-labelledby="details-modals-{{ $item->id }}" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="details-modals-{{ $item->id }}-label"><b>Cập nhật đánh
                                giá</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('save_review', ['id' => $item->id]) }}">
                            @csrf
                            <x-user-select disabled selected="{{ $item->user_id }}" />
                            <x-tour-select disabled selected="{{ $item->tour_id }}" />
                            <x-input name="rating" label="Số sao" type="number" min="1" max="5"
                                value="{{ $item->rating }}" />
                            <x-input name="content" label="Nội dung" element="texarea" rows="5"
                                value="{{ $item->content }}" />

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
