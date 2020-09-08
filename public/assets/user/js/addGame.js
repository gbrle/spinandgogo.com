let blockAddGame = document.getElementById('blockAddGame');
let blockAddGameRoom = document.getElementById('blockAddGameRoom');
let blockRooms = document.getElementById('blockRooms');
let blockAddBuyIn = document.getElementById('blockAddBuyIn');
let blockBuyIn = document.getElementById('blockBuyIn');

let dataAddGame = {}

blockAddGame.addEventListener('click', function (){
    blockAddGame.classList.remove('intro-y')
    blockAddGame.classList.add('animate__bounceOutLeft')
    setTimeout(function(){
        blockAddGame.style.display = 'none'
        blockAddGameRoom.style.display = "block"
        blockRooms.style.display = "block"

    }, 500);
})

function addRoom(id_room){
    blockAddGameRoom.classList.remove('intro-y')
    blockRooms.classList.remove('intro-y')
    blockAddGameRoom.classList.add('animate__bounceOutLeft')
    blockRooms.classList.add('animate__bounceOutLeft')
    dataAddGame.id_room = id_room;

    ajaxPost('/user/user_get_buy_in', id_room, function (response){

        Object.response(response).forEach(function (key) {
          console.log(response[0][])
        })


        setTimeout(function(){
            blockAddGameRoom.style.display = "none"
            blockRooms.style.display = "none"

            // I add all buy in in front (javascript only) I get the Json
            let buyButtons = document.getElementById('buyButtons')


            let button = document.createElement("button");
            button.classList.add('paste')
            button.innerText = "{{ room.id }}"

            buyButtons.appendChild(button)

            blockAddBuyIn.style.display = 'block'
            blockBuyIn.style.display = 'block'



        }, 500);


    })


}