let blockAddGame = document.getElementById('blockAddGame');
let blockAddGameRoom = document.getElementById('blockAddGameRoom');
let blockRooms = document.getElementById('blockRooms');

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
        console.log((response))
    })
    setTimeout(function(){
        blockAddGameRoom.style.display = 'none'
        blockRooms.style.display = 'none'

    }, 500);


}