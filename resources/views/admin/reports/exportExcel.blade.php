<table>
<thead>
<tr>
    <th>Customer ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>IC Number</th>
    <th>Phone No</th>
    <th>Email</th>
    <th>Quantity</th>
    <th>Total Price</th>
    <th>Payment Status</th>
    <th>Payment Method</th>
    <th>Event Name</th>

</tr>
</thead>
<tbody>
@foreach ($student as $students) 
@foreach($payment as $payments)
@foreach($package as $packages)
@if ($payments->stud_id == $students->stud_id)
    <tr>
        <td>{{ $students->stud_id }}</td>
        <td>{{ $students->first_name }}</td>
        <td>{{ $students->last_name }}</td>
        <td>{{ $students->ic }}</td>
        <td>{{ $students->phoneno }}</td>
        <td>{{ $students->email }}</td>
        <td>{{ $payments->quantity }}</td>
        <td>{{ $payments->totalprice }}</td>
        <td>{{ $payments->status }}</td>
        <td>{{ $payments->pay_method }}</td>
        <td>{{ $packages->name }}</td>
    </tr>
@endif
@endforeach
@endforeach
@endforeach
</tbody>