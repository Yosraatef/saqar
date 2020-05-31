@extends('dashboard.index')
@section('styles')
<style type="text/css">
  .items{
    display: none;
  }
</style>
@endsection
@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>
        اضافة  خدمة   فرعية جديدة      </h3>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('subCategories.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

           
              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                  <div class="form-group">
                <label for="category_id"> الصنف  </label>
                <select id="myList" class="form-control" name="category_id" >
                     <option>اختر الخدمة التابعه لها </option>
                  @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
               <p class="editableText" id="$bid"> {{$category->name}}</p>

                  @endforeach
                </select>
              </div>
              
                <div  id="select_others" class="form-group">
                <label for="name">اسم  الخدمه الفرعية </label>
                <input type="text" name="name"
                       placeholder="ادخل  اسم  الخدمة "
                       class="form-control">
                </div>
                <div id="select_other" class="form-group image" >
                      <label for="image">صورة  الخدمة الفرعية</label>
                      <br>
                  <input type="file" name="image" id="image">
                </div>
             
            
            
            </div>
            
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('categories.index') }}">الرجوع</a>
              </div>
                </div>

              </div> 
            </form>
    @endsection