@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

{{-- Custom button css ----------------------------}}
<style>
    .button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 32px 16px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 4px 5px;
    transition-duration: 0.4s;
    cursor: pointer;
    }
    .button4 {
    background-color: #f3f3f3;
    color: #202020;
    border: 1px #e7e7e7 solid;
    width: 150px;
    }

    .button4:hover {background-color: #e7e7e7;}
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center">
            <img src="/assets/images/logo.png" style="max-width:150px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 py-3">
            <form action="{{ url('save-details') }}/{{ $product->product_id }}/{{ $current_package->package_id }}/{{ $student->stud_id }}/{{ $payment->payment_id }}" method="POST">
                @csrf
  
                <div class="container text-center">
                    <div class="row">
                        <div class="col-auto pb-4 d-block mx-auto">
                            <div class="pricing-item bg-white py-4 px-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">
                                <div class="border-bottom pb-1" style="letter-spacing: 2px">
                                    <h4>Maklumat Tiket</h4>
                                </div>
                                
                                @foreach ($package as $packages)
                                @if ($new_package->package_id == $packages->package_id)
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th>Pakej</th>
                                                <th>Harga</th>
                                                <th>Kuantiti</th>
                                                <th class="text-center">Jumlah Bayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $packages->name }}</td>
                                                <td>
                                                    <input type="hidden" id="price" value="{{ $packages->price }}" disabled>
                                                    {{-- RM <input type="text" id="new_price" name="price" value="{{ $new_package->price ?? '' }}" style="border: none; width: 40px" readonly> --}}
                                                    RM <span id="new_price"></span>
                                                    
                                                </td>
                                                <td>
                                                    <select name="quantity" onchange="new_amount(this.value)" class="form-control w-100" required>
                                                    <option value="" disabled selected>-</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    RM <input type="text" id="new_total" class="text-center" name="totalprice" value="{{ $new_package->totalprice ?? '' }}" style="border: none; width: 40px" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>   
                                @endif  
                                @endforeach                           

                                <div class="row-fluid pt-1">
                                    <div class="alert alert-info text-left" role="alert">
                                         <i class="fas fa-info-circle pr-1 border-right border-info"></i>  Harga pakej di atas telah ditolak daripada pembayaran pakej sebelum
                                     </div> 
                                 </div>
                                {{-- <div class="py-2">
                                    <p style="text-decoration: line-through;">RM{{ $current_package->price }}</p>
                                    <span id="price"></span>
                                </div> --}}                                
                                <div class="col-md-12 pb-5">
                                    <div class="pull-left">
                                        <a href="{{ url('upgrade-package') }}/{{ $product->product_id }}/{{ $current_package->package_id }}/{{ $student->stud_id }}/{{$payment->payment_id}}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right py-1"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                    
            </form>
        </div>
    </div>
</div>



<script>
    var x = document.getElementById("price").value;
    var y = '{{ $current_package->price }}';
    var z = x - y;

    /*display the result*/
    var total = document.getElementById('new_price');
    total.value = z;

    // document.getElementById("new_price").innerHTML = z;
    console.log(z);
</script>

<script>
function new_amount(val) {
        
    var newprice = document.getElementById("new_price").value;
    var newamount = val * newprice;

    /*display the result*/
    var divobj = document.getElementById('new_total');
    divobj.value = newamount;\

    console.log(newamount);
}
</script>
@endsection