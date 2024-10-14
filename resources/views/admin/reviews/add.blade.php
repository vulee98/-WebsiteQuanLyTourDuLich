<x-layout title="Thêm booking">
    <h3 class="display-4 text-center">
        TẠO MỘT ĐÁNH GIÁ
    </h3>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (\Session::has('error_mesg'))
            <div class="alert alert-danger">
                {{ \Session::get('error_mesg') }}
            </div>
        @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('save_review') }}">
                @csrf
                <x-user-select />
                <x-tour-select />
                <x-input name="rating" label="Số sao" type="number" min="1" max="5" />
                <x-input name="content" label="Nội dung" element="texarea" rows="5" />

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-block">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
