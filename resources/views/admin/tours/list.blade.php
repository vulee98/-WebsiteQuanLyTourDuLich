<x-layout title="Quản lý tours">

    <div>
        <div>
            <!-- Begin Page Content -->
            <div class="container-fluid"><br />

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Thông tin các tours</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="{{ route('add_tour') }}"><button type="submit" class="btn btn-primary ">Thêm tour
                            </button></a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã tour</th>
                                        <th>Tên tour</th>
                                        <th>Giá</th>
                                        <th>Ảnh bìa</th>
                                        <th>Số lượng thành viên tối đa</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($tours as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>

                                            <td><img src="/storage/img/tours/{{ $item->imageCover }}" width="100px"
                                                    alt="{{ $item->imageCover }}" /></td>

                                            <td>{{ $item->maxGroupSize }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>

                                            <td>
                                                <button class="btn btn-info text-white" data-toggle="modal"
                                                    data-target="#details-modal-{{ $item->id }}">Xem</button>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#details-modals-{{ $item->id }}">Cập nhật</button>
                                                <a href="{{ route('delete_tour', ['id' => $item->id]) }}"
                                                    class="btn btn-danger">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $tours->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->

    @foreach ($tours as $item)
        @php
            $current_tour_id = $item->id;
            $current_guide_id = $item->guide_id;
            
            // Lấy các hình của tour hiện tại
            $images = array_filter($tour_images, function ($image) use ($current_tour_id) {
                return $image['tour_id'] == $current_tour_id;
            });
            
            // Lấy các locations của tour hiện tại
            $current_locations = array_filter($locations, function ($location) use ($current_tour_id) {
                return $location['tour_id'] == $current_tour_id;
            });
            
            // Lấy hướng dẫn viên du lịch của tour hiện tại
            $current_guide = array_filter($guides, function ($guide) use ($current_guide_id) {
                return $guide['id'] == $current_guide_id;
            });
        @endphp

        <div class="modal fade" id="details-modal-{{ $item->id }}" tabindex="-1"
            aria-labelledby="details-modal-{{ $item->id }}" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="details-modal-{{ $item->id }}-label"><b>Chi tiết tour</b>
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
                                <b>Tên tour:&nbsp;</b>{{ $item->name }}
                            </td><br><br>

                            <td>
                                <b>Giá:&nbsp;</b>{{ $item->price }}
                            </td><br><br>

                            <td>
                                <b>Chuyến đi trong vòng:&nbsp;</b>{{ $item->duration }} ngày
                            </td><br><br>

                            <td>
                                <b>Độ khó:&nbsp; </b>{{ $item->difficulty }}
                            </td><br><br>

                            <td>
                                <b>Ảnh bìa:&nbsp;</b>
                                <div>
                                    <img src="/storage/img/tours/{{ $item->imageCover }}" width="80%"
                                        alt="{{ $item->imageCover }}" />
                                </div>
                            </td><br><br>

                            <td>
                                <b>Các hình ảnh của tour:&nbsp;</b>
                                <div>
                                    @if ($images != null)
                                        @foreach ($images as $image)
                                            <img src="/storage/img/tours/{{ $image['name'] }}" width="30%"
                                                alt="{{ $image['name'] }}" />
                                        @endforeach
                                    @endif
                                </div>
                            </td><br><br>

                            <td>
                                <b>Số lượng thành viên tối đa:&nbsp;</b>{{ $item->maxGroupSize }}
                            </td><br><br>

                            <td>
                                <b>Thông tin các địa điểm của tour:&nbsp;</b>
                                @if ($current_locations != null)
                                    <div class="row">
                                        @foreach ($current_locations as $location)
                                            <div class="col-6">
                                                <p class="text-center font-weight-bold">Ngày {{ $location['day'] }}
                                                </p>
                                                <b>Kinh độ: </b> {{ $location['longitude'] }} <br />
                                                <b>Vĩ độ: </b> {{ $location['latitude'] }} <br />
                                                <b>Ngày bắt đầu: </b> {{ $location['startDate'] }} <br />
                                                <b>Địa chỉ: </b> {{ $location['description'] }} <br />
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td><br><br>

                            <td>
                                @if (isset($current_guide) && $current_guide != null)
                                    <b>Hướng dẫn viên du lịch:&nbsp;
                                    </b>
                                    @foreach ($current_guide as $guide)
                                        {{ $guide['name'] . ' (' . $guide['email'] . ')' }}
                                    @endforeach
                                @endif
                            </td><br><br>


                            <td>
                                <b>Tóm tắt:&nbsp; </b>{{ $item->summary }}
                            </td><br><br>

                            <td>
                                <b>Mô tả:&nbsp;</b>{{ $item->description }}
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
    @foreach ($tours as $item)
        <div class="modal fade" id="details-modals-{{ $item->id }}" tabindex="-1"
            aria-labelledby="details-modals-{{ $item->id }}" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="details-modals-{{ $item->id }}-label"><b>Cập nhật tour</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('save_tour', ['id' => $item->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <x-input name="name" label="Tên tour" value="{{ $item->name ?? '' }} " />
                            <x-input name="price" label="Giá" value="{{ $item->price ?? '' }}" />
                            <x-input name="duration" label="Chuyến đi trong vòng" type="number"
                                value="{{ $item->duration ?? '' }}" />
                            <x-input name="difficulty" label="Độ khó" element='select'
                                selected="{{ $item->difficulty ?? '' }}" data="dễ,trung bình,khó" />
                            <x-input type="file" label="Ảnh bìa" name="imageCover" />
                            <x-input type="file" label="Các hình ảnh của tour" name="images[]" multiple />
                            <x-input name="maxGroupSize" label="Số lượng thành viên tối đa" type="number"
                                value="{{ $item->maxGroupSize ?? '' }}" />
                            <x-guide-select-component selected="{{ $item->guide_id }}" />
                            {{-- <x-input id="numberOfLocations" name="numberOfLocations" label="Số địa điểm" type="number"
                                min="1" /> --}}
                            <x-input name="summary" label="Tóm tắt" value="{{ $item->summary ?? '' }}" />
                            <x-input name="description" label="Mô tả chi tiết" textarea rows="5" element='textarea'
                                value="{{ $item->description ?? '' }}" />
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
