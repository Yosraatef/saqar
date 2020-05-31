@extends('dashboard.index')
@section('content')
    <h2> الخدمات</h2>
    <div class="col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th> الاسم </th>
                <th> الصورة </th>
                <th> النسبة </th>
                <th> سعر الخدمات الثابته </th>
                <th> شكل عرض الخدمات الفرعية</th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($categories) > 0)
                @foreach($categories as $category)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$category->name}}</td>
                        <td><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/categories/' . $category->image) }}"></td>
                        <td>{{$category->commission}}</td>
                        <td>{{$category->price}}</td>
                        @if($category->is_select == 2)
                        <td>اسم وصورة </td>
                        @elseif($category->is_select == 1)
                        <td>اختيار</td>
                        @else
                        <td>لا يوجد خدمة فرعية لها </td>
                        @endif
                        <td><a href="{{route('categories.edit', $category->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>

                        <td>

                            <form action="{{route('categories.destroy',$category->id)}}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button class="btn btn-outline-danger">احذف</button>

                            </form> 
                        </td>

                    </tr>
                    </tbody>
                @endforeach
            @endif
        </table>

        {{ $categories->links() }}

    </div>

@endsection