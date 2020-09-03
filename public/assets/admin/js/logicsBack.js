function addMultiplicator(id) {
	let value = document.getElementById("multiplicatorInput"+id)


	ajaxPost("/admin/addMultiplicatorForOneBuyIn/"+id+"", value.value, function (response) {


		console.log(value.value)
		window.location.href = '/admin/room/'+response;
	})
}