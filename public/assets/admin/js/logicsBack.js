function addPrice(id, ranked, room) {


	let numberInput1 = ranked
	let numberInput2 = ranked+1
	let numberInput3 = ranked+2

	let position1 = document.getElementById("rankedInput"+numberInput1)
	let position2 = document.getElementById("rankedInput"+numberInput2)
	let position3 = document.getElementById("rankedInput"+numberInput3)



	ajaxPost("/admin/addPrice", JSON.stringify([ranked, position1.value, position2.value, position3.value]), function (response) {

		window.location.href = '/admin/room/'+room;
	})
}
function addMultiplicator(id) {
	let value = document.getElementById("multiplicatorInput"+id)


	ajaxPost("/admin/addMultiplicatorForOneBuyIn/"+id+"", value.value, function (response) {

		window.location.href = '/admin/room/'+response;
	})
}