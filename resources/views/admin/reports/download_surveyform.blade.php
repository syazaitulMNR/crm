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
            <th>Class</th>
            <th>Pay Price</th>
            <th>Registered At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ticket as $tickets)
            @foreach ($student as $students)
                @if ($tickets->ic == $students->ic)
                    @foreach($business as $businessdetails)
                        @if ($tickets->ticket_id == $businessdetails->ticket_id)
                            <tr>
                                <td>{{$students->first_name}}</td>
                                <td>{{$students->last_name}}</td>
                                <td>{{$students->ic}}</td>
                                <td>{{$students->phoneno}}</td>
                                <td>{{$students->email}}</td>
                                <td>{{$students->gender}}</td>
                                <td>{{$businessdetails->business_type}}</td>
                                <td>{{$businessdetails->business_role}}</td>
                                <td>{{$businessdetails->business_amount}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$tickets->pay_price}}</td>
                                <td>{{$tickets->created_at}}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>