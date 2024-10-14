<x-layout title="Thống kê các đơn đặt tour">

    <div>
        <div>
            <!-- Begin Page Content -->
            <div class="container-fluid"><br />

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Thông tin các đơn đặt theo tour</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên tour</th>
                                        <th>Ngày khởi hành</th>
                                        <th>Số vé đã được đặt</th>
                                        <th>Số đơn đã duyệt</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item['tourName'] }}</td>
                                            <td>{{ $item['startDate'] }}</td>
                                            <td>{{ $item['numberOfPeopleBooked'] }}/{{ $item['maxGroupSize'] }}</td>
                                            <td>{{ $item['approvedOrderQuantity'] }}</td>
                                            <td>{{ $item['totalMoney'] }} VNĐ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $data->links() }} --}}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
</x-layout>
