<x-layout title="Thêm tour">
    <h3 class="display-4 text-center">
        TẠO MỘT TOUR
    </h3>
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('save_tour') }}" enctype="multipart/form-data">
                @csrf
                <x-input name="name" label="Tên tour" />
                <x-input name="price" label="Giá" />
                <x-input name="duration" label="Chuyến đi trong vòng" type="number" />
                <x-input name="difficulty" label="Độ khó" element='select' data="dễ,trung bình,khó" />
                <x-input type="file" label="Ảnh bìa" name="imageCover" />
                <x-input type="file" label="Các hình ảnh của tour" name="images[]" multiple />
                <x-input name="maxGroupSize" label="Số lượng thành viên tối đa" type="number" />
                <x-input id="numberOfLocations" name="numberOfLocations" label="Số địa điểm" type="number" min="1" />
                <div id="locations-container" class="justify-content-center">
                    {{-- form thêm các locations --}}
                </div>
                <x-guide-select-component />
                <x-input name="summary" label="Tóm tắt" />
                <x-input name="description" label="Mô tả chi tiết" textarea rows="5" element='textarea' />

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-block">Thêm</button>
                </div>
            </form>
        </div>
    </div>
    <script src="/js/insertLocationsForm.js"></script>
</x-layout>
