@extends('layouts.app')

@section('title')
    Customer
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')

<div class="row py-5">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Customer Details</h1>
        </div>

        <form action="{{ url('student/details') }}" name="form1" id="form1" method="POST"> 
        @csrf

        <div class="row" style="padding-left:10%">
            <div class="col-md-5">
                <div class="form-group {{ ($errors->has('roll'))?'has-error':'' }}">
              <label for="roll">Event <span class="required">*</span></label>
              <select name="product" class="form-control" id="product">
                  <option value="">-- Select Event --</option>
                  @foreach ($product as $products)
                      <option value="{{ $products->product_id }}">{{ ucfirst($products->name) }}</option>
                  @endforeach
              </select>
           </div>
            </div>
            <div class="col-md-5">
                <div class="form-group {{ ($errors->has('name'))?'has-error':'' }}">
              <label for="roll">Package </label>
              <select name="package" class="form-control" id="package">
              </select>
           </div>
            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="ic" class="col-sm-2 col-form-label text-right">IC No. :</label>
            <div class="col-sm-10">
            <input type="text" class="col-sm-8 form-control" name="ic"  >
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right">Name :</label>
            <div class="col-sm-10">
            <input type="text" class="col-sm-8 form-control" name="name" >
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right">Tel No. :</label>
            <div class="col-sm-10">
            <input type="text" class="col-sm-8 form-control" name="phoneno"  >
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right">Email :</label>
            <div class="col-sm-10">
            <input type="email" class="col-sm-8 form-control" name="email"  >
            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="ic" class="col-sm-2 col-form-label text-right">Address :</label>
            <div class="col-sm-10">
            <textarea type="text" class="col-sm-8 form-control" name="address"> </textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right">Date of Birth :</label>
            <div class="col-sm-10">
            <input type="text" class="col-sm-8 form-control" name="birthdate"  >
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right">Gender :</label>
            <div class="col-sm-10">
            <input type="text" class="col-sm-8 form-control" name="gender"  >
            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right">Company Name :</label>
            <div class="col-sm-10">
            <input type="text" class="col-sm-8 form-control" name="company" >
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right">Position :</label>
            <div class="col-sm-10">
            <input type="text" class="col-sm-8 form-control" name="position"  >
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right">Salary :</label>
            <div class="col-sm-10">
            <input type="text" class="col-sm-8 form-control" name="salary" >
            </div>
        </div>
                    
            <div class='col-md-8'>
                <button type='submit' class='btn btn-primary float-right'> Submit </button>
            </div>
        </form>

    </main>
</div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#product').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: '/findCityWithStateID/'+stateID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        //console.log(data);
                        if(data){
                        $('#package').empty();
                        $('#package').focus;
                        $('#package').append('<option value="">-- Select Package --</option>'); 
                        $.each(data, function(key, value){
                        $('select[name="package"]').append('<option value="'+ key +'">' + value.name + '</option>');
                    });
                    }else{
                    $('#package').empty();
                    }
                    }
                });
            }else{
                $('#package').empty();
            }
        });
    });
</script>

@endsection

<!--
<script>
    var subjectObject = {
      "Roket Pemasaran Momentum (RPM)": {
        "General": ["Links", "Images", "Tables", "Lists"],
        "Gold": ["Borders", "Margins", "Backgrounds", "Float"],
        "Diamond": ["Variables", "Operators", "Functions", "Conditions"]    
      },
      "Advance Roket Bisnes (ARB)": {
        "Economy": ["Variables", "Strings", "Arrays"],
        "Premium": ["SELECT", "UPDATE", "DELETE"],
        "First Class": ["SELECT", "UPDATE", "DELETE"]
      },
      "Intensif Momentum Pemasaran Internet (IMPI)": {
        "Starter": ["Variables", "Strings", "Arrays"],
        "Executive": ["SELECT", "UPDATE", "DELETE"]
      }
    }
    window.onload = function() {
      var subjectSel = document.getElementById("subject");
      var topicSel = document.getElementById("topic");
      var chapterSel = document.getElementById("chapter");
      for (var x in subjectObject) {
        subjectSel.options[subjectSel.options.length] = new Option(x, x);
      }
      subjectSel.onchange = function() {
        //display correct values
        for (var y in subjectObject[this.value]) {
          topicSel.options[topicSel.options.length] = new Option(y, y);
        }
      }
      topicSel.onchange = function() {
        //display correct values
        var z = subjectObject[subjectSel.value][this.value];
        for (var i = 0; i < z.length; i++) {
          chapterSel.options[chapterSel.options.length] = new Option(z[i], z[i]);
        }
      }
    }
</script>
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','.productname', function(){
            //console.log("testing");

            var cat_id=$(this).val();
            //console.log(cat_id);

            $.ajax({
                type:'get',
                url:'{!!URL::to('findpack')!!}',
                data:{'id':cat_id},
                success:function(data){
                    //console.log('success');
                    //console.log(data);
                    //console.log(data.length);
                    op+='<option value="0" selected disabled>chose product</option>';
                    for(var i=0; i<data.length; i++){
                        op+='<option value="'+data[i].id+'">'+data[i].name+'</option>'
                    }
                    div.find('.productname').html("");
                    div.find('.productname').append(op);
                }, 
                error:function(){

                }
            });
        });
    });
</script>-->