<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Bills</h1>
	<ul>
	@foreach ($bill_items as $bill_item)
			<li> {{ $bill_item->number }} </li>
		@endforeach 
	</ul>
</body>
</html>		