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
@foreach($errors as $key=>$error)
    <tr>
        <td>{{ $error[0]}}</td>
        <td>{{ $error[1]}}</td>
        <td>{{ $error[2]}}</td>
        <td>{{ $error[3]}}</td>
    </tr>
@endforeach
</tbody>