<table>
<thead>
<tr>
    <th>Row No.</th>
    <th>Sheet Name</th>
    <th>Row Name</th>
    <th>List Of Errors</th>
</tr>
</thead>
<tbody>
@foreach($payment as $key=>$payments)
    <tr>
        <td>{{ $payments[0]}}</td>
        <td>{{ $payments[1]}}</td>
        <td>{{ $payments[2]}}</td>
        <td>{{ $payments[3]}}</td>
    </tr>
@endforeach
</tbody>