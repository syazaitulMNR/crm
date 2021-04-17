<table>
<thead>
<tr>
    <th>Customer ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>IC Number</th>
    <th>Phone No</th>
    <th>Email</th>
    <th>Payment Status</th>

</tr>
</thead>
<tbody>
@foreach($payment as $key=>$payments)
    <tr>
        <td>{{ $payments->stud_id }}</td>
        <td>{{ $payments->payment_id }}</td>
        <td>{{ $payments->quantity }}</td>
        <td>{{ $payments->status }}</td>
        <td>{{ $payments->totalprice }}</td>
        <td>{{ $payments->product_id }}</td>
        <td>{{ $payments->pay_method }}</td>
    </tr>
@endforeach
</tbody>