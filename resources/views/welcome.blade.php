<form action="paypal" method="POST">
@csrf

<input type="hidden" name="price" value="20">
<input type="text" name="name" >
<button type="submit">submit paypal</button>
</form>