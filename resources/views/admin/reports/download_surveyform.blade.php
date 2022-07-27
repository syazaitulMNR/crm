<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>IC No</th>
            <th>Phone No</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Business Type</th>
            <th>Business Role</th>
            <th>Business Amount</th>
            <th>Programme Name</th>
            {{-- <th>Pay Price</th>
            <th>Registered At</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($business as $businessdetails) 
            <tr>
                <td>{{$businessdetails->first_name}}</td>
                <td>{{$businessdetails->last_name}}</td>
                <td>{{$businessdetails->ic}}</td>
                <td>{{$businessdetails->phoneno}}</td>
                <td>{{$businessdetails->email}}</td>
                <td>{{$businessdetails->gender}}</td>
                <td>{{$businessdetails->business_type}}</td>
                <td>{{$businessdetails->business_role}}</td>
                <td>{{$businessdetails->business_amount}}</td>
                <td>{{$businessdetails->product_name}}</td>
                {{-- <td>{{$tickets->pay_price}}</td> --}}
                {{-- <td>{{$tickets->created_at}}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>