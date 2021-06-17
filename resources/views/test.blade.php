<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table>
		<thead>
		<tr>
			<th>Title</th>
			<th>Question</th>
		</tr>
		</thead>
		<tbody>
			@foreach($user as $users)
			<tr>
				<td>{{$users->title}}</td>
				<td>{{$users->question}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>